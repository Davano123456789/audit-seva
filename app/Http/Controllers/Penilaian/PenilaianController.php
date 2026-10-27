<?php

namespace App\Http\Controllers\Penilaian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Penilaian\SimpanJawabanRequest;
use App\Models\Answer;
use App\Models\Audit;
use App\Models\AuditProcess;
use App\Models\Question;
use App\Services\CapabilityAssessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Halaman penilaian untuk asesor.
 */
class PenilaianController extends Controller
{
    public function __construct(private CapabilityAssessor $assessor)
    {
    }

    /**
     * Daftar proyek audit yang ditugaskan kepada asesor yang sedang login.
     */
    public function index(Request $request)
    {
        $audits = $request->user()->audits()
            ->withCount([
                'processes',
                'processes as completed_processes_count' => fn ($q) => $q->where('status', 'completed'),
            ])
            ->latest()
            ->get();

        return view('penilaian.index', compact('audits'));
    }

    /**
     * Daftar proses dalam satu proyek beserta progres penilaiannya.
     */
    public function show(Request $request, Audit $audit)
    {
        $this->authorizeAudit($request, $audit);

        $audit->load(['processes' => fn ($q) => $q->orderBy('process_code'), 'processes.process']);

        return view('penilaian.show', compact('audit'));
    }

    /**
     * Ruang kerja penilaian satu proses: pertanyaan level aktif, atau hasil jika sudah selesai.
     */
    public function workspace(Request $request, Audit $audit, string $proses)
    {
        $this->authorizeAudit($request, $audit);
        $item = $this->findProcess($audit, $proses);
        $result = $this->assessor->sync($item);

        if ($result['status'] !== CapabilityAssessor::IN_PROGRESS) {
            return view('penilaian.hasil', [
                'audit' => $audit,
                'item' => $item,
                'result' => $result,
                'answersByLevel' => $this->answersByLevel($audit, $proses),
            ]);
        }

        $questions = Question::with('practice')
            ->where('level', $result['active_level'])
            ->whereHas('practice', fn ($q) => $q->where('process_code', $proses))
            ->orderBy('practice_code')
            ->orderBy('id')
            ->get();

        return view('penilaian.workspace', [
            'audit' => $audit,
            'item' => $item,
            'result' => $result,
            'questionsByPractice' => $questions->groupBy('practice_code'),
            'total' => $questions->count(),
            'answers' => Answer::where('project_id', $audit->id)
                ->whereIn('question_id', $questions->pluck('id'))
                ->get()
                ->keyBy('question_id'),
        ]);
    }

    /**
     * Simpan jawaban level aktif, lalu evaluasi untuk menentukan level berikutnya.
     */
    public function simpan(SimpanJawabanRequest $request, Audit $audit, string $proses)
    {
        $this->authorizeAudit($request, $audit);
        $item = $this->findProcess($audit, $proses);
        $before = $this->assessor->evaluate($audit, $proses);
        $level = (int) $request->level;

        // Mencegah penyimpanan dari halaman lama (misal dibuka di dua tab)
        if ($before['status'] !== CapabilityAssessor::IN_PROGRESS || $before['active_level'] !== $level) {
            return redirect()->route('penilaian.workspace', [$audit, $proses])
                ->with('error', 'Halaman sudah tidak sesuai dengan progres terbaru, silakan periksa kembali.');
        }

        $questionIds = Question::where('level', $level)
            ->whereHas('practice', fn ($q) => $q->where('process_code', $proses))
            ->pluck('id');

        // Semua pertanyaan level ini wajib dijawab; jika belum lengkap tidak ada yang disimpan
        $unanswered = $questionIds->reject(fn ($id) => in_array($request->input("answers.{$id}"), [Answer::YES, Answer::NO], true))->count();

        if ($unanswered > 0) {
            return back()->withInput()
                ->with('error', "Masih ada {$unanswered} pertanyaan yang belum dijawab. Lengkapi semua jawaban sebelum mengevaluasi Level {$level}.");
        }

        foreach ($questionIds as $questionId) {
            $answer = $request->input("answers.{$questionId}");
            $existing = Answer::where('project_id', $audit->id)->where('question_id', $questionId)->first();
            $evidence = $existing?->evidence_file;

            if ($file = $request->file("evidence.{$questionId}")) {
                $evidence = $file->storeAs(
                    "evidences/{$audit->id}",
                    "bukti_{$questionId}_" . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension(),
                    'public'
                );

                if ($existing?->evidence_file) {
                    Storage::disk('public')->delete($existing->evidence_file);
                }
            }

            Answer::updateOrCreate(
                ['project_id' => $audit->id, 'question_id' => $questionId],
                ['answer' => $answer, 'notes' => $request->input("notes.{$questionId}"), 'evidence_file' => $evidence]
            );
        }

        $after = $this->assessor->sync($item);

        // Ringkasan evaluasi ditampilkan sebagai modal di halaman berikutnya
        return redirect()->route('penilaian.workspace', [$audit, $proses])
            ->with('evaluation', $this->evaluationSummary($item, $level, $after));
    }

    /**
     * Hapus seluruh jawaban satu proses dan mulai penilaian dari Level 2 lagi.
     */
    public function reset(Request $request, Audit $audit, string $proses)
    {
        $this->authorizeAudit($request, $audit);
        $item = $this->findProcess($audit, $proses);

        $answers = Answer::where('project_id', $audit->id)
            ->whereHas('question.practice', fn ($q) => $q->where('process_code', $proses))
            ->get();

        Storage::disk('public')->delete($answers->whereNotNull('evidence_file')->pluck('evidence_file')->all());
        Answer::whereIn('id', $answers->pluck('id'))->delete();

        $this->assessor->sync($item);

        return redirect()->route('penilaian.workspace', [$audit, $proses])
            ->with('success', "Penilaian {$proses} berhasil direset, dimulai kembali dari Level " . config('cobit.start_level') . '.');
    }

    private function authorizeAudit(Request $request, Audit $audit): void
    {
        abort_unless($audit->asesor_id === $request->user()->id, 403, 'Proyek ini tidak ditugaskan kepada Anda.');
    }

    private function findProcess(Audit $audit, string $processCode): AuditProcess
    {
        return $audit->processes()->with('process')->where('process_code', $processCode)->firstOrFail();
    }

    /**
     * Jawaban satu proses dikelompokkan per level, untuk ditampilkan di halaman hasil.
     */
    private function answersByLevel(Audit $audit, string $processCode)
    {
        return Answer::with('question')
            ->where('project_id', $audit->id)
            ->whereHas('question.practice', fn ($q) => $q->where('process_code', $processCode))
            ->get()
            ->sortBy(fn ($a) => [$a->question->level, $a->question->practice_code, $a->question_id])
            ->groupBy(fn ($a) => $a->question->level);
    }

    /**
     * Data ringkasan untuk modal setelah sebuah level dievaluasi.
     */
    private function evaluationSummary(AuditProcess $item, int $level, array $result): array
    {
        $completed = $result['status'] === CapabilityAssessor::COMPLETED;
        $capability = $completed ? $result['capability_level'] : null;

        return [
            'process_code' => $item->process_code,
            'process_name' => $item->process->name,
            'level' => $level,
            'score' => $result['history'][$level],
            'completed' => $completed,
            'next_level' => $completed ? null : $result['active_level'],
            'capability_level' => $capability,
            'capability_name' => CapabilityAssessor::levelName($capability),
            'target' => $item->target_level,
            'gap' => $completed ? max(0, $item->target_level - $capability) : null,
        ];
    }
}
