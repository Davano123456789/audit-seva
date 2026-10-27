@props(['level'])

@php
    $colors = [
        2 => 'bg-sky-100 text-sky-800',
        3 => 'bg-brand-100 text-brand-800',
        4 => 'bg-amber-100 text-amber-800',
        5 => 'bg-violet-100 text-violet-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center whitespace-nowrap rounded-md px-2 py-0.5 text-xs font-semibold ' . ($colors[$level] ?? 'bg-gray-100 text-gray-700')]) }}>
    Level {{ $level }}
</span>
