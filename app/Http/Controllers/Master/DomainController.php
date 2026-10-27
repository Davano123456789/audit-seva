<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DomainRequest;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $domains = Domain::withCount('processes')
            ->when($request->q, fn ($query, $q) => $query->where(fn ($w) => $w
                ->where('id', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%")))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('master.domain.index', compact('domains'));
    }

    public function create()
    {
        return view('master.domain.create', ['domain' => new Domain()]);
    }

    public function store(DomainRequest $request)
    {
        Domain::create($request->validated());

        return redirect()->route('master.domain.index')->with('success', 'Domain berhasil ditambahkan.');
    }

    public function edit(Domain $domain)
    {
        return view('master.domain.edit', compact('domain'));
    }

    public function update(DomainRequest $request, Domain $domain)
    {
        $domain->update($request->validated());

        return redirect()->route('master.domain.index')->with('success', 'Domain berhasil diperbarui.');
    }

    public function destroy(Domain $domain)
    {
        if ($domain->processes()->exists()) {
            return back()->with('error', "Domain {$domain->id} masih memiliki proses TI, hapus prosesnya terlebih dahulu.");
        }

        $domain->delete();

        return redirect()->route('master.domain.index')->with('success', 'Domain berhasil dihapus.');
    }
}
