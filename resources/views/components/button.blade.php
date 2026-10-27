@props(['href' => null, 'variant' => 'primary', 'icon' => null, 'type' => 'button'])

@php
    $variants = [
        'primary' => 'bg-brand-600 text-white hover:bg-brand-700',
        'secondary' => 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];

    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition '
        . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="h-4 w-4"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<i data-lucide="{{ $icon }}" class="h-4 w-4"></i>@endif
        {{ $slot }}
    </button>
@endif
