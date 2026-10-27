@extends('layouts.app')

@section('title', 'Proses TI')

@section('content')
    <x-page-header title="Proses TI" subtitle="Proses TI COBIT 2019 yang menjadi objek penilaian.">
        <x-slot:actions>
            <x-button :href="route('master.proses.create')" icon="plus">Tambah Proses</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <x-filter-bar :action="route('master.proses.index')" placeholder="Cari kode atau nama proses...">
            <select name="domain" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-64">
                <option value="">Semua domain</option>
                @foreach ($domainOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('domain') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-filter-bar>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Proses</th>
                        <th class="px-4 py-3">Domain</th>
                        <th class="px-4 py-3 text-center">Jumlah Praktik</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($processes as $process)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3"><x-badge color="green">{{ $process->code }}</x-badge></td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $process->name }}</p>
                                @if ($process->description)
                                    <p class="text-xs text-gray-500">{{ $process->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $process->domain->id }} &middot; {{ $process->domain->name }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('master.praktik.index', ['proses' => $process->code]) }}" class="font-medium text-brand-700 hover:underline">
                                    {{ $process->practices_count }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :edit="route('master.proses.edit', $process)"
                                    :delete="route('master.proses.destroy', $process)"
                                    label="proses {{ $process->code }}" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="5" message="Tidak ada proses TI yang ditemukan." />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($processes->hasPages())
            <div class="border-t border-gray-100 p-4">{{ $processes->links() }}</div>
        @endif
    </x-card>
@endsection
