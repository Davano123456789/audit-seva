{{-- Banner sapaan di atas dashboard: sapaan sesuai waktu, nama, role, dan tanggal hari ini --}}
@props(['subtitle' => null])

@php
    $user = auth()->user();
    $hour = (int) now()->format('G');
    $greeting = match (true) {
        $hour >= 4 && $hour < 11 => 'Selamat pagi',
        $hour >= 11 && $hour < 15 => 'Selamat siang',
        $hour >= 15 && $hour < 18 => 'Selamat sore',
        default => 'Selamat malam',
    };
@endphp

<div class="relative mb-6 overflow-hidden rounded-xl bg-gradient-to-r from-brand-800 to-brand-600 px-6 py-7 text-white">
    {{-- Ornamen lingkaran dekoratif --}}
    <div class="pointer-events-none absolute -right-10 -top-16 h-48 w-48 rounded-full bg-white/10"></div>
    <div class="pointer-events-none absolute -bottom-20 right-24 h-40 w-40 rounded-full bg-white/5"></div>

    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm text-brand-100">{{ $greeting }},</p>
            <h2 class="mt-0.5 text-2xl font-bold">{{ $user->name }}</h2>
            @if ($subtitle)
                <p class="mt-2 max-w-xl text-sm text-brand-100">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2 text-xs">
            <span class="rounded-full bg-white/15 px-3 py-1 font-medium">{{ $user->role_label }}</span>
            <span class="rounded-full bg-white/15 px-3 py-1">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>
</div>
