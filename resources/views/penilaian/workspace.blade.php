@extends('layouts.app')

@section('title', 'Penilaian ' . $item->process_code)

@section('content')
    @php
        $level = $result['active_level'];
        $number = 0;
    @endphp

    <x-page-header :title="$item->process_code . ' · ' . $item->process->name"
                   subtitle="{{ $audit->name }} — target Level {{ $item->target_level }}">
        <x-slot:actions>
            <x-button :href="route('penilaian.show', $audit)" variant="secondary" icon="arrow-left">Kembali</x-button>
        </x-slot:actions>
    </x-page-header>

    @include('penilaian.partials._stepper')

    <form method="POST" action="{{ route('penilaian.simpan', [$audit, $item->process_code]) }}" enctype="multipart/form-data" id="assessment-form">
        @csrf
        <input type="hidden" name="level" value="{{ $level }}">

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Daftar pertanyaan per praktik --}}
            <div class="space-y-4 lg:col-span-2">
                @foreach ($questionsByPractice as $practiceCode => $questions)
                    <x-card>
                        <div class="border-b border-gray-100 bg-gray-50/70 px-5 py-3">
                            <p class="text-sm font-semibold">
                                <span class="text-brand-700">{{ $practiceCode }}</span> &middot; {{ $questions->first()->practice->name }}
                            </p>
                            @if ($questions->first()->practice->description)
                                <p class="text-xs text-gray-500">{{ $questions->first()->practice->description }}</p>
                            @endif
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach ($questions as $question)
                                @include('penilaian.partials._question', [
                                    'answer' => $answers->get($question->id),
                                    'number' => ++$number,
                                ])
                            @endforeach
                        </div>
                    </x-card>
                @endforeach
            </div>

            {{-- Ringkasan & tombol simpan --}}
            <div>
                <div class="space-y-4 lg:sticky lg:top-20">
                    <x-card class="p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="font-semibold">Level {{ $level }}</h3>
                            <x-level-badge :level="$level" />
                        </div>

                        <div class="mb-1 flex justify-between text-xs text-gray-500">
                            <span>Terjawab</span>
                            <span><strong id="sum-answered" class="text-ink">0</strong> / {{ $total }}</span>
                        </div>
                        <div class="mb-4 h-2 overflow-hidden rounded-full bg-gray-100">
                            <div id="sum-bar" class="h-full rounded-full bg-brand-500 transition-all" style="width: 0%"></div>
                        </div>

                        <dl class="grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg bg-brand-50 p-2">
                                <dt class="text-[11px] text-gray-500">Ya</dt>
                                <dd id="sum-yes" class="text-lg font-bold text-brand-700">0</dd>
                            </div>
                            <div class="rounded-lg bg-red-50 p-2">
                                <dt class="text-[11px] text-gray-500">Tidak</dt>
                                <dd id="sum-no" class="text-lg font-bold text-red-600">0</dd>
                            </div>
                            <div class="rounded-lg bg-gray-50 p-2">
                                <dt class="text-[11px] text-gray-500">Capaian</dt>
                                <dd id="sum-percent" class="text-lg font-bold">0%</dd>
                            </div>
                        </dl>

                        <div class="mt-4 rounded-lg border border-dashed border-gray-300 p-3 text-sm">
                            <div class="mb-1 flex items-center gap-2">
                                <span class="text-xs text-gray-500">Rating:</span>
                                <span id="sum-rating" class="font-semibold">-</span>
                            </div>
                            <p id="sum-decision" class="text-xs text-gray-600">Jawab semua pertanyaan untuk melihat hasil level ini.</p>
                        </div>

                        <div class="mt-3 flex gap-2 text-xs">
                            <button type="button" data-fill="Y" class="flex-1 rounded-md border border-gray-200 py-1.5 text-gray-600 hover:bg-gray-50">Semua Ya</button>
                            <button type="button" data-fill="N" class="flex-1 rounded-md border border-gray-200 py-1.5 text-gray-600 hover:bg-gray-50">Semua Tidak</button>
                        </div>

                        <x-button type="submit" icon="check-check" class="mt-4 w-full">
                            Simpan &amp; Evaluasi Level {{ $level }}
                        </x-button>
                        <p class="mt-2 text-[11px] text-gray-400">
                            Semua pertanyaan wajib dijawab sebelum dievaluasi.
                        </p>
                    </x-card>

                    <x-card class="p-5">
                        <h3 class="mb-3 text-sm font-semibold">Skala Penilaian</h3>
                        @include('penilaian.partials._rating-legend')
                    </x-card>
                </div>
            </div>
        </div>
    </form>

    @if ($item->status === 'in_progress')
        <form method="POST" action="{{ route('penilaian.reset', [$audit, $item->process_code]) }}" class="mt-6 text-right"
              data-confirm="Reset penilaian {{ $item->process_code }}?"
              data-confirm-text="Semua jawaban dan file bukti proses ini akan dihapus, penilaian dimulai lagi dari Level {{ config('cobit.start_level') }}."
              data-confirm-button="Ya, reset">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1 text-xs font-medium text-red-600 hover:underline">
                <i data-lucide="rotate-ccw" class="h-3.5 w-3.5"></i> Reset penilaian proses ini
            </button>
        </form>
    @endif

    @if (session('evaluation'))
        @include('penilaian.partials._evaluation-modal', ['evaluation' => session('evaluation')])
    @endif
@endsection

@push('scripts')
    <script>
        // Ringkasan langsung: jumlah terjawab, persentase Ya, rating, dan prediksi keputusan
        (function () {
            const form = document.getElementById('assessment-form');
            const total = @json($total);
            const level = @json($level);
            const hasNextLevel = @json($result['has_next_level']);
            const ratings = @json(config('cobit.ratings'));
            const levelNames = @json(collect(config('cobit.levels'))->map->name);

            const el = id => document.getElementById(id);
            const radios = () => form.querySelectorAll('input[type=radio][name^="answers["]:checked');

            const ratingOf = percent => Object.keys(ratings).find(code => percent >= ratings[code].min) || 'N';

            const update = () => {
                const checked = [...radios()];
                const answered = checked.length;
                const yes = checked.filter(r => r.value === 'Y').length;
                const percent = total ? Math.round(yes / total * 10000) / 100 : 0;

                el('sum-answered').textContent = answered;
                el('sum-bar').style.width = (total ? answered / total * 100 : 0) + '%';
                el('sum-yes').textContent = yes;
                el('sum-no').textContent = answered - yes;
                el('sum-percent').textContent = percent.toLocaleString('id-ID') + '%';

                if (answered < total) {
                    el('sum-rating').textContent = '-';
                    el('sum-decision').textContent = `Masih ada ${total - answered} pertanyaan yang belum dijawab.`;
                    return;
                }

                const rating = ratingOf(percent);
                el('sum-rating').textContent = `${rating} · ${ratings[rating].name}`;

                let decision;
                if (rating === 'F') {
                    decision = hasNextLevel
                        ? `Level ${level} lulus, penilaian lanjut ke level berikutnya.`
                        : `Level ${level} lulus. Penilaian selesai dengan Capability Level ${level} (${levelNames[level]}).`;
                } else {
                    const capability = rating === 'L' ? level : level - 1;
                    decision = `Penilaian berhenti. Capability Level ${capability} (${levelNames[capability]}).`;
                }
                el('sum-decision').textContent = decision;
            };

            // Tandai ada perubahan yang belum disimpan, untuk peringatan saat meninggalkan halaman
            let dirty = false;
            const markDirty = () => { dirty = true; };

            form.addEventListener('change', () => { markDirty(); update(); });
            form.addEventListener('input', markDirty);

            document.querySelectorAll('[data-fill]').forEach(btn => btn.addEventListener('click', () => {
                form.querySelectorAll(`input[type=radio][value="${btn.dataset.fill}"]`).forEach(r => r.checked = true);
                markDirty();
                update();
            }));

            window.addEventListener('beforeunload', event => {
                if (!dirty) return;
                event.preventDefault();
                event.returnValue = ''; // browser menampilkan pesan bawaan "perubahan belum disimpan"
            });

            // Konfirmasi sebelum evaluasi karena level yang sudah dievaluasi hanya bisa diubah lewat reset
            form.addEventListener('submit', event => {
                if (form.dataset.confirmed) return;
                event.preventDefault();

                const missing = total - radios().length;
                Swal.fire(missing > 0 ? {
                    icon: 'info',
                    title: 'Belum lengkap',
                    text: `Masih ada ${missing} pertanyaan yang belum dijawab. Lengkapi semua jawaban terlebih dahulu.`,
                } : {
                    icon: 'question',
                    title: `Evaluasi Level ${level}?`,
                    text: el('sum-decision').textContent + ' Jawaban level ini tidak dapat diubah kecuali dengan reset.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, evaluasi',
                    cancelButtonText: 'Periksa lagi',
                    confirmButtonColor: '#059669',
                    reverseButtons: true,
                }).then(res => {
                    if (missing === 0 && res.isConfirmed) {
                        form.dataset.confirmed = '1';
                        dirty = false; // sedang disimpan, jangan tampilkan peringatan meninggalkan halaman
                        form.submit();
                    }
                });
            });

            update();
        })();
    </script>
@endpush
