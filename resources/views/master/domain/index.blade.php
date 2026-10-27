@extends('layouts.app')

@section('title', 'Domain')

@section('content')
    <x-page-header title="Domain COBIT" subtitle="Kelompok besar proses TI dalam kerangka kerja COBIT 2019.">
        <x-slot:actions>
            <x-button :href="route('master.domain.create')" icon="plus">Tambah Domain</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <x-filter-bar :action="route('master.domain.index')" placeholder="Cari kode atau nama domain..." />

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Domain</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-center">Jumlah Proses</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($domains as $domain)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3"><x-badge color="green">{{ $domain->id }}</x-badge></td>
                            <td class="px-4 py-3 font-medium">{{ $domain->name }}</td>
                            <td class="max-w-md px-4 py-3 text-gray-500">{{ Str::limit($domain->description, 90) ?: '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('master.proses.index', ['domain' => $domain->id]) }}" class="font-medium text-brand-700 hover:underline">
                                    {{ $domain->processes_count }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :edit="route('master.domain.edit', $domain)"
                                    :delete="route('master.domain.destroy', $domain)"
                                    label="domain {{ $domain->id }}" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="5" message="Belum ada domain." />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($domains->hasPages())
            <div class="border-t border-gray-100 p-4">{{ $domains->links() }}</div>
        @endif
    </x-card>
@endsection
