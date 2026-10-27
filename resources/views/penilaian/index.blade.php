@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
    <x-page-header title="Proyek Penilaian Saya" subtitle="Daftar proyek audit yang ditugaskan kepada Anda." />

    @forelse ($audits as $audit)
        <x-card class="mb-4 p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="font-semibold">{{ $audit->name }}</h3>
                        <x-badge :color="$audit->status_color">{{ $audit->status_label }}</x-badge>
                    </div>
                    @if ($audit->description)
                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($audit->description, 140) }}</p>
                    @endif
                    <p class="mt-1 text-xs text-gray-400">Ditugaskan {{ $audit->created_at->translatedFormat('d F Y') }}</p>
                </div>

                <div class="flex w-full shrink-0 flex-col gap-3 md:w-72">
                    <div>
                        <p class="mb-1 text-xs text-gray-500">Proses selesai dinilai</p>
                        <x-progress :value="$audit->completed_processes_count" :total="$audit->processes_count" />
                    </div>
                    <x-button :href="route('penilaian.show', $audit)" icon="clipboard-check">
                        {{ $audit->status === 'draft' ? 'Mulai Penilaian' : 'Buka Proyek' }}
                    </x-button>
                </div>
            </div>
        </x-card>
    @empty
        <x-card class="p-12 text-center">
            <i data-lucide="inbox" class="mx-auto mb-2 h-10 w-10 text-gray-300"></i>
            <p class="text-sm text-gray-500">Belum ada proyek audit yang ditugaskan kepada Anda.</p>
        </x-card>
    @endforelse
@endsection
