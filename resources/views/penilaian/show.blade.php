@extends('layouts.app')

@section('title', 'Proyek Penilaian')

@section('content')
    @php
        $total = $audit->processes->count();
        $completed = $audit->processes->where('status', 'completed')->count();
    @endphp

    <x-page-header :title="$audit->name" subtitle="Pilih proses TI yang akan dinilai.">
        <x-slot:actions>
            <x-button :href="route('penilaian.index')" variant="secondary" icon="arrow-left">Kembali</x-button>
            <x-button :href="route('laporan.show', $audit)" variant="secondary" icon="file-text">Laporan</x-button>
        </x-slot:actions>
    </x-page-header>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <x-card class="p-4">
            <p class="text-xs text-gray-500">Status Proyek</p>
            <div class="mt-1"><x-badge :color="$audit->status_color">{{ $audit->status_label }}</x-badge></div>
        </x-card>
        <x-card class="p-4">
            <p class="text-xs text-gray-500">Proses Selesai Dinilai</p>
            <p class="mt-1 font-semibold">{{ $completed }} dari {{ $total }} proses</p>
            <x-progress class="mt-2" :value="$completed" :total="$total" />
        </x-card>
        <x-card class="p-4">
            <p class="text-xs text-gray-500">Maturity Level{{ $audit->status === 'completed' ? '' : ' (sementara)' }}</p>
            <p class="mt-1 text-2xl font-bold text-brand-700">
                {{ $audit->maturity_display }}
            </p>
            @if ($audit->maturity_level !== null)
                <p class="text-xs text-gray-500">Level {{ $audit->maturity_level }} &middot; {{ $audit->maturity_level_name }}</p>
            @endif
        </x-card>
    </div>

    @if ($audit->description)
        <x-card class="mb-6 p-4">
            <p class="text-xs text-gray-500">Deskripsi / Objek Audit</p>
            <p class="mt-1 whitespace-pre-line text-sm">{{ $audit->description }}</p>
        </x-card>
    @endif

    <x-card>
        <div class="border-b border-gray-100 px-4 py-3">
            <h3 class="text-sm font-semibold">Proses TI yang Dinilai</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach ($audit->processes as $item)
                <div class="flex flex-col gap-3 px-4 py-4 md:flex-row md:items-center md:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="font-medium">{{ $item->process_code }} &middot; {{ $item->process->name }}</p>
                            <x-badge :color="$item->status_color">{{ $item->status_label }}</x-badge>
                        </div>
                        <p class="text-xs text-gray-500">{{ $item->process->description }}</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <p class="text-[11px] uppercase text-gray-400">Target</p>
                            <p class="font-semibold">{{ $item->target_level }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[11px] uppercase text-gray-400">Hasil</p>
                            <p class="font-semibold text-brand-700">{{ $item->status === 'completed' ? $item->computed_capability_level : '-' }}</p>
                        </div>
                        <x-button :href="route('penilaian.workspace', [$audit, $item->process_code])"
                                  :variant="$item->status === 'completed' ? 'secondary' : 'primary'"
                                  :icon="match ($item->status) { 'completed' => 'eye', 'in_progress' => 'play', default => 'clipboard-pen' }"
                                  class="w-40">
                            {{ match ($item->status) { 'completed' => 'Lihat Hasil', 'in_progress' => 'Lanjutkan', default => 'Mulai Nilai' } }}
                        </x-button>
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
@endsection
