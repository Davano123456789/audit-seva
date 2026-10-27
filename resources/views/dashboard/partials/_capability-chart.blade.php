{{--
    Grafik batang horizontal: capability level per proses, dengan penanda target.
    Variabel: $chartAudit (Audit|null), $chartOptions ([id => nama])
--}}
@php
    $max = config('cobit.max_level');
@endphp

<x-card>
    <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="font-semibold">Capability Level per Proses</h3>
            <p class="text-xs text-gray-500">Hasil penilaian dibandingkan target level.</p>
        </div>

        @if ($chartOptions->count() > 1)
            <form method="GET" action="{{ route('dashboard') }}">
                <select name="audit" onchange="this.form.submit()" aria-label="Pilih proyek"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-64">
                    @foreach ($chartOptions as $id => $name)
                        <option value="{{ $id }}" @selected($chartAudit?->id === $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </form>
        @elseif ($chartAudit)
            <p class="text-sm font-medium text-gray-600">{{ $chartAudit->name }}</p>
        @endif
    </div>

    @if (! $chartAudit)
        <div class="px-5 py-12 text-center">
            <i data-lucide="bar-chart-3" class="mx-auto mb-2 h-10 w-10 text-gray-300"></i>
            <p class="text-sm text-gray-500">Grafik muncul setelah ada proses yang selesai dinilai.</p>
        </div>
    @else
        <div class="px-5 py-5">
            {{-- Sumbu level 0 - 5 (posisi sama dengan garis bantu di bawah) --}}
            <div class="mb-2 flex gap-3">
                <span class="w-16 shrink-0"></span>
                <div class="relative h-4 flex-1 text-[11px] text-gray-400">
                    @foreach (range(0, $max) as $tick)
                        <span class="absolute -translate-x-1/2" style="left: {{ $tick / $max * 100 }}%">{{ $tick }}</span>
                    @endforeach
                </div>
            </div>

            <div class="space-y-3">
                @foreach ($chartAudit->processes as $item)
                    @php
                        $done = $item->status === 'completed';
                        $level = $done ? $item->computed_capability_level : null;
                        $tooltip = $item->process_code . ' · ' . $item->process->name
                            . ' — ' . ($done ? 'Level ' . $level . ' (' . \App\Services\CapabilityAssessor::levelName($level) . ')' : 'belum selesai dinilai')
                            . ', target ' . $item->target_level;
                    @endphp

                    <div class="group flex items-center gap-3" title="{{ $tooltip }}">
                        <span class="w-16 shrink-0 text-xs font-semibold text-gray-600">{{ $item->process_code }}</span>

                        <div class="relative h-7 flex-1">
                            {{-- Garis bantu tiap level --}}
                            @foreach (range(0, $max) as $tick)
                                <span class="absolute inset-y-0 w-px bg-gray-100" style="left: {{ $tick / $max * 100 }}%"></span>
                            @endforeach

                            @if ($done)
                                <div class="absolute inset-y-1 left-0 flex items-center justify-end rounded-r bg-brand-600 pr-2 transition group-hover:bg-brand-700"
                                     style="width: {{ max($level / $max * 100, 0.8) }}%">
                                    @if ($level > 0)
                                        <span class="text-xs font-semibold text-white">{{ $level }}</span>
                                    @endif
                                </div>
                            @else
                                <div class="absolute inset-y-1 left-0 flex items-center pl-2">
                                    <span class="text-xs italic text-gray-400">belum selesai</span>
                                </div>
                            @endif

                            {{-- Penanda target --}}
                            <div class="absolute inset-y-0 w-0.5 -translate-x-1/2 bg-ink" style="left: {{ $item->target_level / $max * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-brand-600"></span> Capability level</span>
                <span class="flex items-center gap-1.5"><span class="h-3 w-0.5 bg-ink"></span> Target level</span>
                @if ($chartAudit->maturity_index !== null)
                    <span class="ml-auto font-medium text-gray-600">
                        Maturity {{ $chartAudit->maturity_display }} &middot; Level {{ $chartAudit->maturity_level }} ({{ $chartAudit->maturity_level_name }})
                    </span>
                @endif
            </div>
        </div>
    @endif
</x-card>
