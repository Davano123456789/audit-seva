<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PraktikRequest;
use App\Models\ItProcess;
use App\Models\Practice;
use Illuminate\Http\Request;

class PraktikController extends Controller
{
    public function index(Request $request)
    {
        $practices = Practice::with('process')
            ->withCount('questions')
            ->when($request->proses, fn ($query, $proses) => $query->where('process_code', $proses))
            ->when($request->q, fn ($query, $q) => $query->where(fn ($w) => $w
                ->where('code', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('master.praktik.index', [
            'practices' => $practices,
            'processOptions' => $this->processOptions(),
        ]);
    }

    public function create(Request $request)
    {
        return view('master.praktik.create', [
            // Proses otomatis terpilih jika datang dari halaman yang sudah difilter
            'praktik' => new Practice(['process_code' => $request->proses]),
            'processOptions' => $this->processOptions(),
        ]);
    }

    public function store(PraktikRequest $request)
    {
        Practice::create($request->validated());

        return redirect()->route('master.praktik.index', ['proses' => $request->process_code])
            ->with('success', 'Praktik berhasil ditambahkan.');
    }

    public function edit(Practice $praktik)
    {
        return view('master.praktik.edit', [
            'praktik' => $praktik,
            'processOptions' => $this->processOptions(),
        ]);
    }

    public function update(PraktikRequest $request, Practice $praktik)
    {
        $praktik->update($request->validated());

        return redirect()->route('master.praktik.index', ['proses' => $praktik->process_code])
            ->with('success', 'Praktik berhasil diperbarui.');
    }

    public function destroy(Practice $praktik)
    {
        if ($praktik->questions()->exists()) {
            return back()->with('error', "Praktik {$praktik->code} masih memiliki pertanyaan, hapus pertanyaannya terlebih dahulu.");
        }

        $praktik->delete();

        return back()->with('success', 'Praktik berhasil dihapus.');
    }

    /**
     * Pilihan proses untuk dropdown, contoh: ['APO07' => 'APO07 - Managed Human Resources'].
     */
    private function processOptions(): array
    {
        return ItProcess::orderBy('code')->get()
            ->mapWithKeys(fn ($p) => [$p->code => "{$p->code} - {$p->name}"])
            ->all();
    }
}
