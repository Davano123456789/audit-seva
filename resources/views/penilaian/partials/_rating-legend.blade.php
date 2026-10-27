{{-- Skala penilaian (Tabel 2.2) beserta aturan lanjut/berhenti --}}
@php
    $ratings = config('cobit.ratings');
    $upper = 100; // batas atas rating pertama (F)
@endphp

<div class="space-y-2 text-xs">
    @foreach ($ratings as $code => $rating)
        <div class="flex items-center justify-between gap-2">
            <span class="flex items-center gap-2">
                <x-rating-badge :rating="$code" />
                <span class="text-gray-600">{{ $rating['name'] }}</span>
            </span>
            <span class="whitespace-nowrap text-gray-500">
                {{ $rating['min'] }}% &ndash; {{ $loop->first ? '100%' : '< ' . $upper . '%' }}
            </span>
        </div>
        @php
            $upper = $rating['min'];
        @endphp
    @endforeach

    <div class="mt-3 space-y-1 rounded-lg bg-gray-50 p-3 text-gray-600">
        <p><strong>F</strong>: level lulus, lanjut ke level berikutnya.</p>
        <p><strong>L</strong>: berhenti, capability = level ini.</p>
        <p><strong>P / N</strong>: berhenti, capability = level sebelumnya.</p>
    </div>
</div>
