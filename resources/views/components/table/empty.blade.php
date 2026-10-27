@props(['colspan', 'message' => 'Belum ada data.'])

<tr>
    <td colspan="{{ $colspan }}" class="px-4 py-12 text-center">
        <i data-lucide="inbox" class="mx-auto mb-2 h-8 w-8 text-gray-300"></i>
        <p class="text-sm text-gray-500">{{ $message }}</p>
    </td>
</tr>
