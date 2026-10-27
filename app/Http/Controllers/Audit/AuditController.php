<?php

namespace App\Http\Controllers\Audit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Audit\AuditRequest;
use App\Models\Audit;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Pengelolaan proyek audit oleh admin.
 */
class AuditController extends Controller
{
    public function index(Request $request)
    {
        $audits = Audit::with('asesor')
            ->withCount([
                'processes',
                'processes as completed_processes_count' => fn ($q) => $q->where('status', 'completed'),
            ])
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->asesor, fn ($query, $asesor) => $query->where('asesor_id', $asesor))
            ->when($request->q, fn ($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('audit.index', [
            'audits' => $audits,
            'asesorOptions' => $this->asesorOptions(),
        ]);
    }

    public function create()
    {
        return view('audit.create', [
            'audit' => new Audit(),
            'asesorOptions' => $this->asesorOptions(),
            'domains' => $this->domainsWithProcesses(),
            'selected' => [],
        ]);
    }

    public function store(AuditRequest $request)
    {
        $audit = DB::transaction(function () use ($request) {
            $audit = Audit::create($request->safe()->only(['name', 'description', 'asesor_id']) + ['status' => 'draft']);

            foreach ($request->processes as $code) {
                $audit->processes()->create([
                    'process_code' => $code,
                    'target_level' => $request->targetLevelFor($code),
                ]);
            }

            return $audit;
        });

        return redirect()->route('audit.index')->with('success', 'Proyek audit berhasil dibuat.');
    }

    public function show(Audit $audit)
    {
        $audit->load(['asesor', 'processes' => fn ($q) => $q->orderBy('process_code'), 'processes.process.domain']);

        return view('audit.show', compact('audit'));
    }

    public function edit(Audit $audit)
    {
        $audit->load('processes');

        return view('audit.edit', [
            'audit' => $audit,
            'asesorOptions' => $this->asesorOptions(),
            'domains' => $this->domainsWithProcesses(),
            // [kode proses => AuditProcess] untuk menandai proses yang sudah dipilih
            'selected' => $audit->processes->keyBy('process_code')->all(),
        ]);
    }

    public function update(AuditRequest $request, Audit $audit)
    {
        DB::transaction(function () use ($request, $audit) {
            $audit->update($request->safe()->only(['name', 'description', 'asesor_id']));

            $existing = $audit->processes()->get()->keyBy('process_code');
            $chosen = collect($request->processes);

            // Hapus proses yang tidak dipilih lagi, kecuali yang sudah mulai dinilai
            foreach ($existing as $code => $item) {
                if (! $chosen->contains($code) && ! $item->isLocked()) {
                    $item->delete();
                }
            }

            foreach ($chosen as $code) {
                if ($item = $existing->get($code)) {
                    $item->update(['target_level' => $request->targetLevelFor($code)]);
                } else {
                    $audit->processes()->create([
                        'process_code' => $code,
                        'target_level' => $request->targetLevelFor($code),
                    ]);
                }
            }
        });

        return redirect()->route('audit.index')->with('success', 'Proyek audit berhasil diperbarui.');
    }

    public function destroy(Audit $audit)
    {
        DB::transaction(function () use ($audit) {
            // File bukti ikut dihapus dari penyimpanan
            $files = $audit->answers()->whereNotNull('evidence_file')->pluck('evidence_file')->all();
            Storage::disk('public')->delete($files);

            $audit->delete();
        });

        return redirect()->route('audit.index')->with('success', 'Proyek audit berhasil dihapus.');
    }

    private function asesorOptions(): array
    {
        return User::where('role', User::ROLE_ASESOR)->orderBy('name')->pluck('name', 'id')->all();
    }

    private function domainsWithProcesses()
    {
        return Domain::with(['processes' => fn ($q) => $q->orderBy('code')])
            ->whereHas('processes')
            ->orderBy('id')
            ->get();
    }
}
