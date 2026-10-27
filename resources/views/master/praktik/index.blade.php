@extends('layouts.app')

@section('title', 'Praktik')

@section('content')
    <x-page-header title="Management Practice" subtitle="Praktik di dalam setiap proses TI. Setiap pertanyaan penilaian terhubung ke salah satu praktik.">
        <x-slot:actions>
            <x-button :href="route('master.praktik.create', request()->only('proses'))" icon="plus">Tambah Praktik</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <x-filter-bar :action="route('master.praktik.index')" placeholder="Cari kode atau nama praktik...">
            <select name="proses" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-72">
                <option value="">Semua proses</option>
                @foreach ($processOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('proses') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-filter-bar>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Praktik</th>
                        <th class="px-4 py-3">Proses</th>
                        <th class="px-4 py-3 text-center">Jumlah Pertanyaan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($practices as $practice)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3"><x-badge color="green">{{ $practice->code }}</x-badge></td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $practice->name }}</p>
                                @if ($practice->description)
                                    <p class="text-xs text-gray-500">{{ $practice->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $practice->process->code }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($practice->questions_count)
                                    <x-badge color="blue">{{ $practice->questions_count }}</x-badge>
                                @else
                                    <span class="text-gray-400">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :edit="route('master.praktik.edit', $practice)"
                                    :delete="route('master.praktik.destroy', $practice)"
                                    label="praktik {{ $practice->code }}" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="5" message="Tidak ada praktik yang ditemukan." />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($practices->hasPages())
            <div class="border-t border-gray-100 p-4">{{ $practices->links() }}</div>
        @endif
    </x-card>
@endsection
