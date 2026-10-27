{{-- Kartu angka ringkasan di dashboard --}}
@props(['label', 'value', 'icon', 'hint' => null])

<x-card {{ $attributes->merge(['class' => 'p-5']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-sm text-gray-500">{{ $label }}</p>
            <p class="mt-1 text-3xl font-bold text-ink">{{ $value }}</p>
            @if ($hint)
                <p class="mt-1 truncate text-xs text-gray-500">{{ $hint }}</p>
            @endif
        </div>
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
        </div>
    </div>
</x-card>
