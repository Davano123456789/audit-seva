{{-- Ringkasan jumlah pertanyaan per proses dan level. Angka bisa diklik untuk memfilter tabel. --}}
<x-card class="mb-6">
    <div class="flex items-center gap-2 border-b border-gray-100 px-4 py-3">
        <i data-lucide="grid-3x3" class="h-4 w-4 text-brand-600"></i>
        <h3 class="text-sm font-semibold">Ringkasan Jumlah Pertanyaan</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-2 text-left">Proses</th>
                    @foreach (\App\Models\Question::LEVELS as $level)
                        <th class="px-4 py-2 text-center">Level {{ $level }}</th>
                    @endforeach
                    <th class="px-4 py-2 text-center">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($processes as $process)
                    @php($counts = $summary[$process->code] ?? [])
                    <tr @class(['bg-brand-50/60' => request('proses') === $process->code])>
                        <td class="px-4 py-2">
                            <span class="font-semibold">{{ $process->code }}</span>
                            <span class="hidden text-gray-500 md:inline">&middot; {{ $process->name }}</span>
                        </td>
                        @foreach (\App\Models\Question::LEVELS as $level)
                            <td class="px-4 py-2 text-center">
                                @if ($count = $counts[$level] ?? 0)
                                    <a href="{{ route('master.pertanyaan.index', ['proses' => $process->code, 'level' => $level]) }}"
                                       class="font-medium text-brand-700 hover:underline">{{ $count }}</a>
                                @else
                                    <span class="text-gray-300">&ndash;</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('master.pertanyaan.index', ['proses' => $process->code]) }}"
                               class="font-semibold text-ink hover:underline">{{ array_sum($counts) }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>
