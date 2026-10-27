<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Services\AuditReport;
use Illuminate\Http\Request;

/**
 * Laporan hasil audit, dapat dibuka admin dan asesor pemilik proyek.
 */
class LaporanController extends Controller
{
    public function __construct(private AuditReport $report)
    {
    }

    public function show(Request $request, Audit $audit)
    {
        $this->authorizeAudit($request, $audit);

        return view('laporan.show', ['report' => $this->report->build($audit)]);
    }

    public function cetak(Request $request, Audit $audit)
    {
        $this->authorizeAudit($request, $audit);

        return view('laporan.cetak', ['report' => $this->report->build($audit)]);
    }

    private function authorizeAudit(Request $request, Audit $audit): void
    {
        $user = $request->user();

        abort_unless($user->isAdmin() || $audit->asesor_id === $user->id, 403, 'Anda tidak memiliki akses ke laporan ini.');
    }
}
