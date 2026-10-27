{{-- Progress bar, contoh: <x-progress :value="2" :total="6" /> menampilkan "2/6" --}}
@props(['value', 'total'])

@php($percent = $total > 0 ? round($value / $total * 100) : 0)

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <div class="h-2 flex-1 overflow-hidden rounded-full bg-gray-100">
        <div class="h-full rounded-full bg-brand-500 transition-all" style="width: {{ $percent }}%"></div>
    </div>
    <span class="whitespace-nowrap text-xs font-medium text-gray-600">{{ $value }}/{{ $total }}</span>
</div>
