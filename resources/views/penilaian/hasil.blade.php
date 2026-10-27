@extends('layouts.app')

@section('title', 'Hasil ' . $item->process_code)

@section('content')
    @php
        $capability = $result['capability_level'];
        $gap = $capability !== null ? max(0, $item->target_level - $capability) : null;
    @endphp

    <x-page-header :title="$item->process_code . ' · ' . $item->process->name" subtitle="{{ $audit->name }} — hasil penilaian">
        <x-slot:actions>
            <x-button :href="route('penilaian.show', $audit)" variant="secondary" icon="arrow-left">Kembali</x-button>
        </x-slot:actions>
    </x-page-header>

    @include('penilaian.partials._stepper')

    @if ($result['status'] === \App\Services\CapabilityAssessor::EMPTY)
        <x-card class="p-10 text-center">
            <i data-lucide="file-question" class="mx-auto mb-2 h-10 w-10 text-gray-300"></i>
            <p class="font-medium">Proses ini belum memiliki pertanyaan.</p>
            <p class="mt-1 text-sm text-gray-500">Hubungi administrator untuk menambahkan pertanyaan pada menu Data Master.</p>
        </x-card>
    @else
        {{-- Hasil akhir --}}
        <div class="mb-6 grid gap-4 lg:grid-cols-3">
            <x-card class="flex items-center gap-5 p-6 lg:col-span-2">
                <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-2xl bg-brand-600 text-white">
                    <span class="text-[11px] uppercase tracking-wide">Level</span>
                    <span class="text-3xl font-bold leading-none">{{ $capability }}</span>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Capability Level</p>
                    <p class="text-xl font-bold text-ink">{{ \App\Services\CapabilityAssessor::levelName($capability) }}</p>
                    <p class="mt-1 text-sm text-gray-600">{{ config("cobit.levels.{$capability}.description") }}</p>
                </div>
            </x-card>

            <x-card class="grid grid-cols-2 divide-x divide-gray-100 p-0">
                <div class="p-6 text-center">
                    <p class="text-xs text-gray-500">Target</p>
                    <p class="mt-1 text-3xl font-bold">{{ $item->target_level }}</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-xs text-gray-500">Gap</p>
                    <p @class(['mt-1 text-3xl font-bold', 'text-red-600' => $gap > 0, 'text-brand-700' => $gap === 0])>{{ $gap }}</p>
                    <p class="text-[11px] text-gray-400">{{ $gap > 0 ? 'Belum mencapai target' : 'Target tercapai' }}</p>
                </div>
            </x-card>
        </div>

        {{-- Rincian per level --}}
        <x-card class="mb-6">
            <div class="border-b border-gray-100 px-4 py-3">
                <h3 class="text-sm font-semibold">Rincian Perhitungan per Level</h3>
                <p class="text-xs text-gray-500">Capaian = jumlah jawaban Ya &divide; jumlah pertanyaan &times; 100%</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Level</th>
                            <th class="px-4 py-3 text-center">Pertanyaan</th>
                            <th class="px-4 py-3 text-center">Ya</th>
                            <th class="px-4 py-3 text-center">Tidak</th>
                            <th class="px-4 py-3 text-center">Capaian</th>
                            <th class="px-4 py-3 text-center">Rating</th>
                            <th class="px-4 py-3">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($result['history'] as $level => $h)
                            <tr>
                                <td class="px-4 py-3"><x-level-badge :level="$level" /></td>
                                @if ($h['status'] === 'skipped')
                                    <td colspan="6" class="px-4 py-3 text-gray-400">Tidak ada pertanyaan, level dilewati.</td>
                                @else
                                    <td class="px-4 py-3 text-center">{{ $h['total'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $h['yes'] }}</td>
                                    <td class="px-4 py-3 text-center">{{ $h['no'] }}</td>
                                    <td class="px-4 py-3 text-center font-semibold">{{ number_format($h['percent'], 2, ',', '.') }}%</td>
                                    <td class="px-4 py-3 text-center"><x-rating-badge :rating="$h['rating']" full /></td>
                                    <td class="px-4 py-3 text-gray-600">{{ \App\Services\CapabilityAssessor::decisionText($level, $h['rating']) }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        {{-- Jawaban per level --}}
        <x-card class="mb-6">
            <div class="border-b border-gray-100 px-4 py-3">
                <h3 class="text-sm font-semibold">Jawaban Asesor</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach ($answersByLevel as $level => $levelAnswers)
                    <details class="group">
                        <summary class="flex cursor-pointer list-none items-center justify-between px-4 py-3 hover:bg-gray-50">
                            <span class="flex items-center gap-2">
                                <i data-lucide="chevron-right" class="h-4 w-4 text-gray-400 transition group-open:rotate-90"></i>
                                <x-level-badge :level="$level" />
                                <span class="text-sm text-gray-600">{{ $levelAnswers->count() }} jawaban</span>
                            </span>
                        </summary>
                        <div class="overflow-x-auto border-t border-gray-100">
                            <table class="w-full text-left text-sm">
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($levelAnswers as $answer)
                                        <tr class="align-top">
                                            <td class="w-10 px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                                            <td class="w-28 px-4 py-3"><x-badge color="green">{{ $answer->question->practice_code }}</x-badge></td>
                                            <td class="px-4 py-3">
                                                <p>{{ $answer->question->question_text }}</p>
                                                @if ($answer->notes)
                                                    <p class="mt-1 text-xs text-gray-500"><strong>Bukti hasil kerja:</strong> {{ $answer->notes }}</p>
                                                @endif
                                            </td>
                                            <td class="w-24 px-4 py-3 text-center">
                                                <x-badge :color="$answer->answer === 'Y' ? 'green' : 'red'">{{ $answer->answer === 'Y' ? 'Ya' : 'Tidak' }}</x-badge>
                                            </td>
                                            <td class="w-24 px-4 py-3 text-center">
                                                @if ($answer->evidence_file)
                                                    <a href="{{ Storage::disk('public')->url($answer->evidence_file) }}" target="_blank"
                                                       class="inline-flex items-center gap-1 text-xs font-medium text-sky-700 hover:underline">
                                                        <i data-lucide="file-check" class="h-3.5 w-3.5"></i> Bukti
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-300">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </details>
                @endforeach
            </div>
        </x-card>
    @endif

    {{-- Reset --}}
    <x-card class="flex flex-col gap-3 border-red-100 p-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-semibold">Ulangi penilaian proses ini</p>
            <p class="text-xs text-gray-500">Semua jawaban dan file bukti {{ $item->process_code }} akan dihapus, penilaian dimulai lagi dari Level {{ config('cobit.start_level') }}.</p>
        </div>
        <form method="POST" action="{{ route('penilaian.reset', [$audit, $item->process_code]) }}"
              data-confirm="Reset penilaian {{ $item->process_code }}?"
              data-confirm-text="Semua jawaban dan file bukti proses ini akan dihapus."
              data-confirm-button="Ya, reset">
            @csrf
            <x-button type="submit" variant="danger" icon="rotate-ccw">Reset Penilaian</x-button>
        </form>
    </x-card>

    @if (session('evaluation'))
        @include('penilaian.partials._evaluation-modal', ['evaluation' => session('evaluation')])
    @endif
@endsection
