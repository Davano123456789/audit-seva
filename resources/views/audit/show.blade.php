@extends('layouts.app')

@section('title', 'Detail Proyek Audit')

@section('content')
    <x-page-header :title="$audit->name" subtitle="Detail proyek audit dan progres penilaian per proses.">
        <x-slot:actions>
            <x-button :href="route('audit.index')" variant="secondary" icon="arrow-left">Kembali</x-button>
            <x-button :href="route('audit.edit', $audit)" variant="secondary" icon="pencil">Edit</x-button>
            <x-button :href="route('laporan.show', $audit)" icon="file-text">Laporan</x-button>
        </x-slot:actions>
    </x-page-header>

    @php
        $total = $audit->processes->count();
        $completed = $audit->processes->where('status', 'completed')->count();
    @endphp

    {{-- Ringkasan --}}
    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-card class="p-4">
            <p class="text-xs text-gray-500">Asesor</p>
            <p class="mt-1 font-semibold">{{ $audit->asesor->name }}</p>
            <p class="text-xs text-gray-500">{{ $audit->asesor->email }}</p>
        </x-card>
        <x-card class="p-4">
            <p class="text-xs text-gray-500">Status</p>
            <div class="mt-1"><x-badge :color="$audit->status_color">{{ $audit->status_label }}</x-badge></div>
            <p class="mt-1 text-xs text-gray-500">Dibuat {{ $audit->created_at->translatedFormat('d F Y') }}</p>
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
            <p class="text-xs text-gray-500">
                {{ $audit->maturity_level !== null ? 'Level ' . $audit->maturity_level . ' · ' . $audit->maturity_level_name : 'Belum ada proses yang selesai' }}
            </p>
        </x-card>
    </div>

    @if ($audit->description)
        <x-card class="mb-6 p-4">
            <p class="text-xs text-gray-500">Deskripsi / Objek Audit</p>
            <p class="mt-1 whitespace-pre-line text-sm">{{ $audit->description }}</p>
        </x-card>
    @endif

    {{-- Daftar proses --}}
    <x-card>
        <div class="border-b border-gray-100 px-4 py-3">
            <h3 class="text-sm font-semibold">Proses TI yang Diaudit</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="w-12 px-4 py-3">No</th>
                        <th class="px-4 py-3">Proses TI</th>
                        <th class="px-4 py-3">Domain</th>
                        <th class="px-4 py-3 text-center">Target</th>
                        <th class="px-4 py-3 text-center">Capability Level</th>
                        <th class="px-4 py-3 text-center">Gap</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($audit->processes as $item)
                        @php
                            $done = $item->status === 'completed';
                            $gap = $done ? max(0, $item->target_level - $item->computed_capability_level) : null;
                        @endphp
                        <tr>
                            <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $item->process_code }} &middot; {{ $item->process->name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->process->description }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $item->process->domain_id }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->target_level }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($done)
                                    <p class="font-semibold">{{ $item->computed_capability_level }}</p>
                                    <p class="text-xs text-gray-500">{{ \App\Services\CapabilityAssessor::levelName($item->computed_capability_level) }}</p>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($done)
                                    <span @class(['font-semibold', 'text-red-600' => $gap > 0, 'text-brand-700' => $gap === 0])>
                                        {{ $gap }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3"><x-badge :color="$item->status_color">{{ $item->status_label }}</x-badge></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
@endsection
