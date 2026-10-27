{{-- Form pencarian di atas tabel. Filter tambahan (select) bisa diletakkan di slot. --}}
@props(['action', 'placeholder' => 'Cari...'])

<form method="GET" action="{{ $action }}" class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:flex-row sm:items-center">
    <div class="relative flex-1">
        <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}"
               class="w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
    </div>

    {{ $slot }}

    <div class="flex gap-2">
        <x-button type="submit" variant="secondary" icon="filter">Terapkan</x-button>
        @if (request()->hasAny(['q', 'domain', 'proses', 'level', 'role', 'status', 'asesor']))
            <x-button :href="$action" variant="secondary" icon="x">Reset</x-button>
        @endif
    </div>
</form>
