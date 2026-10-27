@props(['route', 'icon', 'active' => null])

@php
    // Menu yang route-nya belum dibuat tetap tampil, tapi tidak bisa diklik.
    // $active boleh berisi beberapa pola dipisah koma, contoh: "audit.*,laporan.*"
    $exists = Route::has($route);
    $isActive = $exists && request()->routeIs(...explode(',', $active ?? $route));
@endphp

<a href="{{ $exists ? route($route) : '#' }}"
   @class([
       'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors',
       'bg-white text-brand-800 shadow-sm' => $isActive,
       'text-brand-100 hover:bg-white/10 hover:text-white' => ! $isActive && $exists,
       'cursor-not-allowed text-brand-100/40' => ! $exists,
   ])>
    <i data-lucide="{{ $icon }}" class="h-4 w-4 shrink-0"></i>
    <span>{{ $slot }}</span>
</a>
