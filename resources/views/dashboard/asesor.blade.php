@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-welcome-banner subtitle="Lanjutkan penilaian capability level pada proyek yang ditugaskan kepada Anda." />

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <x-stat-card label="Proyek Ditugaskan" :value="$stats['audits']" icon="folder-kanban"
                     hint="{{ $stats['audits_completed'] }} proyek selesai" />
        <x-stat-card label="Proses Selesai Dinilai" icon="list-checks"
                     :value="$stats['processes_completed'] . '/' . $stats['processes']"
                     hint="Total proses dari semua proyek" />
        <x-stat-card label="Sisa Proses" icon="hourglass" :value="$stats['processes'] - $stats['processes_completed']"
                     hint="Belum selesai dinilai" />
    </div>

    <x-card>
        <div class="border-b border-gray-100 px-5 py-4">
            <h3 class="font-semibold">Lanjutkan Penilaian</h3>
            <p class="text-xs text-gray-500">Proses yang belum selesai dinilai.</p>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse ($pending as $item)
                <a href="{{ route('penilaian.workspace', [$item->project_id, $item->process_code]) }}"
                   class="flex items-center justify-between gap-3 px-5 py-3 transition hover:bg-gray-50">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium">{{ $item->process_code }} &middot; {{ $item->process->name }}</p>
                        <p class="truncate text-xs text-gray-500">{{ $item->audit->name }}</p>
                    </div>
                    <x-badge :color="$item->status_color">{{ $item->status_label }}</x-badge>
                </a>
            @empty
                <div class="px-5 py-10 text-center">
                    <i data-lucide="party-popper" class="mx-auto mb-2 h-8 w-8 text-brand-500"></i>
                    <p class="text-sm text-gray-500">Semua proses sudah selesai dinilai.</p>
                </div>
            @endforelse
        </div>
    </x-card>
@endsection
