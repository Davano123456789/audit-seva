{{-- Badge rating pencapaian: F / L / P / N --}}
@props(['rating', 'full' => false])

@php
    $config = config("cobit.ratings.{$rating}");
@endphp

@if ($config)
    <x-badge :color="$config['color']" :title="$config['name']" {{ $attributes }}>
        {{ $rating }}@if ($full) &middot; {{ $config['name'] }}@endif
    </x-badge>
@else
    <span class="text-gray-400">-</span>
@endif
