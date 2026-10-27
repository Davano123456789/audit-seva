<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProsesRequest;
use App\Models\Domain;
use App\Models\ItProcess;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function index(Request $request)
    {
        $processes = ItProcess::with('domain')
            ->withCount('practices')
            ->when($request->domain, fn ($query, $domain) => $query->where('domain_id', $domain))
            ->when($request->q, fn ($query, $q) => $query->where(fn ($w) => $w
                ->where('code', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")))
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('master.proses.index', [
            'processes' => $processes,
            'domainOptions' => $this->domainOptions(),
        ]);
    }

    public function create()
    {
        return view('master.proses.create', [
            'proses' => new ItProcess(),
            'domainOptions' => $this->domainOptions(),
        ]);
    }

    public function store(ProsesRequest $request)
    {
        ItProcess::create($request->validated());

        return redirect()->route('master.proses.index')->with('success', 'Proses TI berhasil ditambahkan.');
    }

    public function edit(ItProcess $proses)
    {
        return view('master.proses.edit', [
            'proses' => $proses,
            'domainOptions' => $this->domainOptions(),
        ]);
    }

    public function update(ProsesRequest $request, ItProcess $proses)
    {
        $proses->update($request->validated());

        return redirect()->route('master.proses.index')->with('success', 'Proses TI berhasil diperbarui.');
    }

    public function destroy(ItProcess $proses)
    {
        if ($proses->practices()->exists()) {
            return back()->with('error', "Proses {$proses->code} masih memiliki praktik, hapus praktiknya terlebih dahulu.");
        }

        if ($proses->auditProcesses()->exists()) {
            return back()->with('error', "Proses {$proses->code} sudah dipakai di proyek audit.");
        }

        $proses->delete();

        return redirect()->route('master.proses.index')->with('success', 'Proses TI berhasil dihapus.');
    }

    /**
     * Pilihan domain untuk dropdown, contoh: ['APO' => 'APO - Align, Plan and Organize'].
     */
    private function domainOptions(): array
    {
        return Domain::orderBy('id')->get()
            ->mapWithKeys(fn ($d) => [$d->id => "{$d->id} - {$d->name}"])
            ->all();
    }
}
