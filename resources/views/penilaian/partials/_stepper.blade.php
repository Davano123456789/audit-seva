{{--
    Alur level 2 - 5: lulus, berhenti, aktif, dilewati, atau belum/tidak dinilai.
    Variabel: $result (hasil CapabilityAssessor::evaluate)
--}}
@php
    $levels = range(config('cobit.start_level'), config('cobit.max_level'));
    $stoppedAt = collect($result['history'])->search(fn ($h) => $h['status'] === 'stopped');
@endphp

<x-card class="mb-6 p-4">
    <ol class="grid grid-cols-2 gap-3 md:grid-cols-4">
        @foreach ($levels as $level)
            @php
                $h = $result['history'][$level] ?? null;
                $isActive = $result['active_level'] === $level;
                $state = match (true) {
                    $isActive => 'active',
                    $h !== null => $h['status'],
                    $stoppedAt !== false && $level > $stoppedAt => 'not_assessed',
                    default => 'upcoming',
                };
                $caption = match ($state) {
                    'active' => 'Sedang dinilai',
                    'passed' => "{$h['percent']}% · {$h['rating']} (lulus)",
                    'stopped' => "{$h['percent']}% · {$h['rating']} (berhenti)",
                    'skipped' => 'Tanpa pertanyaan',
                    'not_assessed' => 'Tidak dinilai',
                    default => 'Belum terbuka',
                };
            @endphp

            <li @class([
                'flex items-center gap-3 rounded-lg border p-3',
                'border-brand-500 bg-brand-50 ring-2 ring-brand-100' => $state === 'active',
                'border-brand-200 bg-white' => $state === 'passed',
                'border-amber-200 bg-amber-50/50' => $state === 'stopped',
                'border-gray-200 bg-gray-50' => in_array($state, ['skipped', 'upcoming', 'not_assessed']),
            ])>
                <span @class([
                    'flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold',
                    'bg-brand-600 text-white' => in_array($state, ['active', 'passed']),
                    'bg-amber-500 text-white' => $state === 'stopped',
                    'bg-gray-200 text-gray-500' => in_array($state, ['skipped', 'upcoming', 'not_assessed']),
                ])>
                    @if ($state === 'passed')
                        <i data-lucide="check" class="h-4 w-4"></i>
                    @elseif (in_array($state, ['upcoming', 'not_assessed']))
                        <i data-lucide="lock" class="h-4 w-4"></i>
                    @else
                        {{ $level }}
                    @endif
                </span>

                <div class="min-w-0">
                    <p class="text-sm font-semibold">Level {{ $level }}</p>
                    <p class="truncate text-xs text-gray-500">{{ $caption }}</p>
                </div>
            </li>
        @endforeach
    </ol>
</x-card>
