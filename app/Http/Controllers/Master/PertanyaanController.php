<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PertanyaanRequest;
use App\Models\ItProcess;
use App\Models\Question;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with('practice')
            ->when($request->proses, fn ($query, $proses) => $query->whereHas('practice', fn ($p) => $p->where('process_code', $proses)))
            ->when($request->level, fn ($query, $level) => $query->where('level', $level))
            ->when($request->q, fn ($query, $q) => $query->where(fn ($w) => $w
                ->where('question_text', 'like', "%{$q}%")
                ->orWhere('practice_code', 'like', "%{$q}%")))
            ->orderBy('level')
            ->orderBy('practice_code')
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view('master.pertanyaan.index', [
            'questions' => $questions,
            'processes' => ItProcess::orderBy('code')->get(),
            'summary' => $this->summary(),
        ]);
    }

    public function create(Request $request)
    {
        return view('master.pertanyaan.create', [
            'pertanyaan' => new Question([
                'practice_code' => $request->praktik,
                'level' => $request->level,
            ]),
            'processes' => $this->processesWithPractices(),
        ]);
    }

    public function store(PertanyaanRequest $request)
    {
        $question = Question::create($request->validated());

        // Tombol "Simpan & Tambah Lagi": kembali ke form dengan praktik dan level yang sama
        if ($request->boolean('tambah_lagi')) {
            return redirect()
                ->route('master.pertanyaan.create', ['praktik' => $question->practice_code, 'level' => $question->level])
                ->with('success', 'Pertanyaan berhasil ditambahkan.');
        }

        return redirect()
            ->route('master.pertanyaan.index', ['proses' => $question->practice->process_code, 'level' => $question->level])
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Question $pertanyaan)
    {
        return view('master.pertanyaan.edit', [
            'pertanyaan' => $pertanyaan,
            'processes' => $this->processesWithPractices(),
        ]);
    }

    public function update(PertanyaanRequest $request, Question $pertanyaan)
    {
        $pertanyaan->update($request->validated());

        return redirect()
            ->route('master.pertanyaan.index', ['proses' => $pertanyaan->practice->process_code, 'level' => $pertanyaan->level])
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Question $pertanyaan)
    {
        if ($pertanyaan->answers()->exists()) {
            return back()->with('error', 'Pertanyaan ini sudah dijawab pada proyek audit sehingga tidak dapat dihapus.');
        }

        $pertanyaan->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Jumlah pertanyaan per proses per level, contoh: ['APO07' => [2 => 18, 3 => 12, 4 => 4]].
     */
    private function summary(): array
    {
        return Question::query()
            ->join('cobit_practices', 'cobit_practices.code', '=', 'cobit_questions.practice_code')
            ->selectRaw('cobit_practices.process_code, cobit_questions.level, COUNT(*) as total')
            ->groupBy('cobit_practices.process_code', 'cobit_questions.level')
            ->get()
            ->groupBy('process_code')
            ->map(fn ($rows) => $rows->pluck('total', 'level')->all())
            ->all();
    }

    private function processesWithPractices()
    {
        return ItProcess::with(['practices' => fn ($q) => $q->orderBy('code')])->orderBy('code')->get();
    }
}
