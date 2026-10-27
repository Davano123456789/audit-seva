{{--
    Modal ringkasan setelah sebuah level dievaluasi.
    Variabel: $evaluation (PenilaianController::evaluationSummary), $audit
--}}
@php
    $score = $evaluation['score'];
    $rating = config("cobit.ratings.{$score['rating']}");
    $completed = $evaluation['completed'];
@endphp

<div id="evaluation-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" role="dialog" aria-modal="true" aria-labelledby="evaluation-title">
    <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
        {{-- Kepala --}}
        <div @class([
            'px-6 pb-5 pt-6 text-center',
            'bg-brand-50' => ! $completed,
            'bg-gradient-to-b from-brand-50 to-white' => $completed,
        ])>
            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white">
                <i data-lucide="{{ $completed ? 'flag' : 'check' }}" class="h-6 w-6"></i>
            </div>
            <h2 id="evaluation-title" class="text-lg font-bold text-ink">
                {{ $completed ? "Penilaian {$evaluation['process_code']} Selesai" : "Level {$evaluation['level']} Lulus" }}
            </h2>
            <p class="text-sm text-gray-500">{{ $evaluation['process_code'] }} &middot; {{ $evaluation['process_name'] }}</p>
        </div>

        <div class="space-y-5 px-6 py-5">
            {{-- Hasil level yang baru dievaluasi --}}
            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Hasil Level {{ $evaluation['level'] }}</p>
                <dl class="grid grid-cols-4 gap-2 text-center">
                    <div class="rounded-lg bg-gray-50 p-2">
                        <dt class="text-[11px] text-gray-500">Pertanyaan</dt>
                        <dd class="text-lg font-bold">{{ $score['total'] }}</dd>
                    </div>
                    <div class="rounded-lg bg-brand-50 p-2">
                        <dt class="text-[11px] text-gray-500">Ya</dt>
                        <dd class="text-lg font-bold text-brand-700">{{ $score['yes'] }}</dd>
                    </div>
                    <div class="rounded-lg bg-red-50 p-2">
                        <dt class="text-[11px] text-gray-500">Tidak</dt>
                        <dd class="text-lg font-bold text-red-600">{{ $score['no'] }}</dd>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-2">
                        <dt class="text-[11px] text-gray-500">Capaian</dt>
                        <dd class="text-lg font-bold">{{ number_format($score['percent'], 2, ',', '.') }}%</dd>
                    </div>
                </dl>

                <div class="mt-3 flex flex-wrap items-center justify-between gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm">
                    <span class="flex items-center gap-2">
                        <span class="text-gray-500">Rating</span>
                        <x-rating-badge :rating="$score['rating']" full />
                    </span>
                    <span class="font-medium text-gray-700">
                        {{ $completed ? 'Penilaian berhenti' : "Lanjut ke Level {$evaluation['next_level']}" }}
                    </span>
                </div>
            </div>

            {{-- Capability level akhir (hanya jika penilaian proses selesai) --}}
            @if ($completed)
                <div class="flex items-center gap-4 rounded-xl border border-brand-200 bg-brand-50/50 p-4">
                    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-600 text-white">
                        <span class="text-[10px] uppercase tracking-wide">Level</span>
                        <span class="text-2xl font-bold leading-none">{{ $evaluation['capability_level'] }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-500">Capability Level</p>
                        <p class="font-bold text-ink">{{ $evaluation['capability_name'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-600">Target Level {{ $evaluation['target'] }}</p>
                    </div>
                </div>
            @else
                <p class="rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-600">
                    Capaian Level {{ $evaluation['level'] }} memenuhi kategori <strong>Fully Achieved</strong> (&ge; {{ config('cobit.ratings.F.min') }}%),
                    sehingga penilaian dilanjutkan ke Level {{ $evaluation['next_level'] }}.
                </p>
            @endif
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col-reverse gap-2 border-t border-gray-100 px-6 py-4 sm:flex-row sm:justify-end">
            <x-button :href="route('penilaian.show', $audit)" variant="secondary" icon="list">Kembali ke Daftar Proses</x-button>
            <x-button type="button" data-close-evaluation :icon="$completed ? 'file-check' : 'arrow-right'" autofocus>
                {{ $completed ? 'Lihat Hasil Lengkap' : "Lanjut ke Level {$evaluation['next_level']}" }}
            </x-button>
        </div>
    </div>
</div>

<script>
    // Tutup modal: tombol utama, klik latar belakang, atau tombol Esc
    (function () {
        const modal = document.getElementById('evaluation-modal');
        const close = () => modal.remove();

        modal.querySelector('[data-close-evaluation]').addEventListener('click', close);
        modal.addEventListener('click', event => { if (event.target === modal) close(); });
        document.addEventListener('keydown', event => { if (event.key === 'Escape') close(); }, { once: true });
    })();
</script>
