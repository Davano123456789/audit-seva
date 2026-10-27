@extends('layouts.app')

@section('title', 'Pertanyaan')

@section('content')
    <x-page-header title="Pertanyaan Kuesioner" subtitle="Aktivitas yang dinilai Ya/Tidak oleh asesor pada setiap capability level.">
        <x-slot:actions>
            <x-button :href="route('master.pertanyaan.create', ['level' => request('level')])" icon="plus">Tambah Pertanyaan</x-button>
        </x-slot:actions>
    </x-page-header>

    @include('master.pertanyaan._summary')

    <x-card>
        <x-filter-bar :action="route('master.pertanyaan.index')" placeholder="Cari teks pertanyaan atau kode praktik...">
            <select name="proses" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-56">
                <option value="">Semua proses</option>
                @foreach ($processes as $process)
                    <option value="{{ $process->code }}" @selected(request('proses') === $process->code)>{{ $process->code }} - {{ $process->name }}</option>
                @endforeach
            </select>
            <select name="level" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-36">
                <option value="">Semua level</option>
                @foreach (\App\Models\Question::LEVELS as $level)
                    <option value="{{ $level }}" @selected((int) request('level') === $level)>Level {{ $level }}</option>
                @endforeach
            </select>
        </x-filter-bar>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="w-12 px-4 py-3">No</th>
                        <th class="px-4 py-3">Praktik</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Pertanyaan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($questions as $question)
                        <tr class="align-top hover:bg-gray-50/60">
                            <td class="px-4 py-3 text-gray-500">{{ $questions->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3">
                                <x-badge color="green">{{ $question->practice_code }}</x-badge>
                            </td>
                            <td class="px-4 py-3"><x-level-badge :level="$question->level" /></td>
                            <td class="px-4 py-3">
                                <p class="leading-relaxed">{{ $question->question_text }}</p>
                                @if ($question->expected_evidence)
                                    <p class="mt-1 flex items-start gap-1 text-xs text-gray-500">
                                        <i data-lucide="paperclip" class="mt-0.5 h-3 w-3 shrink-0"></i>
                                        {{ $question->expected_evidence }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :edit="route('master.pertanyaan.edit', $question)"
                                    :delete="route('master.pertanyaan.destroy', $question)"
                                    label="pertanyaan ini" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="5" message="Tidak ada pertanyaan yang ditemukan." />
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-500">Total {{ $questions->total() }} pertanyaan</p>
            @if ($questions->hasPages())
                <div>{{ $questions->links() }}</div>
            @endif
        </div>
    </x-card>
@endsection
