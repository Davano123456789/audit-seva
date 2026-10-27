{{-- Tombol Edit + Hapus (dengan konfirmasi SweetAlert) di kolom aksi tabel --}}
@props(['edit', 'delete', 'label' => 'data ini', 'show' => null])

<div class="flex items-center justify-end gap-1">
    @if ($show)
        <a href="{{ $show }}" title="Detail"
           class="rounded-lg p-2 text-gray-500 transition hover:bg-sky-50 hover:text-sky-700">
            <i data-lucide="eye" class="h-4 w-4"></i>
        </a>
    @endif

    <a href="{{ $edit }}" title="Edit"
       class="rounded-lg p-2 text-gray-500 transition hover:bg-brand-50 hover:text-brand-700">
        <i data-lucide="pencil" class="h-4 w-4"></i>
    </a>

    <form method="POST" action="{{ $delete }}" data-confirm="Hapus {{ $label }}?">
        @csrf
        @method('DELETE')
        <button type="submit" title="Hapus"
                class="rounded-lg p-2 text-gray-500 transition hover:bg-red-50 hover:text-red-600">
            <i data-lucide="trash-2" class="h-4 w-4"></i>
        </button>
    </form>
</div>
