<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\AuditProcess;
use App\Models\Domain;
use App\Models\ItProcess;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->isAdmin()
            ? $this->admin()
            : $this->asesor($request);
    }

    private function admin()
    {
        $statusCounts = Audit::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('dashboard.admin', [
            'stats' => [
                'audits' => $statusCounts->sum(),
                'in_progress' => $statusCounts->get('in_progress', 0),
                'completed' => $statusCounts->get('completed', 0),
                'domains' => Domain::count(),
                'processes' => ItProcess::count(),
                'asesors' => User::where('role', User::ROLE_ASESOR)->count(),
                'questions' => Question::count(),
            ],
        ]);
    }

    private function asesor(Request $request)
    {
        $user = $request->user();
        $processes = AuditProcess::whereHas('audit', fn ($q) => $q->where('asesor_id', $user->id));

        return view('dashboard.asesor', [
            'stats' => [
                'audits' => $user->audits()->count(),
                'audits_completed' => $user->audits()->where('status', 'completed')->count(),
                'processes' => (clone $processes)->count(),
                'processes_completed' => (clone $processes)->where('status', 'completed')->count(),
            ],
            // Proses yang belum selesai dinilai, yang sedang berjalan ditampilkan lebih dulu
            'pending' => (clone $processes)->with(['audit', 'process'])
                ->where('status', '!=', 'completed')
                ->orderByRaw("status = 'in_progress' DESC")
                ->orderBy('project_id')
                ->orderBy('process_code')
                ->take(6)
                ->get(),
            ...$this->chartData($request, $user->audits()->getQuery()),
        ]);
    }

    /**
     * Data grafik capability vs target untuk satu proyek (dipilih lewat ?audit=).
     */
    private function chartData(Request $request, $auditQuery): array
    {
        // Hanya proyek yang sudah punya minimal satu proses selesai
        $options = (clone $auditQuery)
            ->whereHas('processes', fn ($q) => $q->where('status', 'completed'))
            ->latest()
            ->pluck('name', 'id');

        $selectedId = $options->has((int) $request->audit) ? (int) $request->audit : $options->keys()->first();

        return [
            'chartOptions' => $options,
            'chartAudit' => $selectedId
                ? Audit::with(['processes' => fn ($q) => $q->orderBy('process_code'), 'processes.process'])->find($selectedId)
                : null,
        ];
    }
}
