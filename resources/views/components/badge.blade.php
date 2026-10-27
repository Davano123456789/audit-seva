@props(['color' => 'gray'])

@php
    $colors = [
        'gray' => 'bg-gray-100 text-gray-700',
        'green' => 'bg-brand-100 text-brand-800',
        'blue' => 'bg-sky-100 text-sky-800',
        'amber' => 'bg-amber-100 text-amber-800',
        'red' => 'bg-red-100 text-red-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold ' . ($colors[$color] ?? $colors['gray'])]) }}>
    {{ $slot }}
</span>
