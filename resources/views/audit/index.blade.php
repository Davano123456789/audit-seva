@extends('layouts.app')

@section('title', 'Proyek Audit')

@section('content')
    <x-page-header title="Proyek Audit" subtitle="Tugaskan asesor untuk menilai capability level proses TI.">
        <x-slot:actions>
            <x-button :href="route('audit.create')" icon="plus">Buat Proyek</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <x-filter-bar :action="route('audit.index')" placeholder="Cari nama proyek...">
            <select name="asesor" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-48">
                <option value="">Semua asesor</option>
                @foreach ($asesorOptions as $id => $name)
                    <option value="{{ $id }}" @selected((int) request('asesor') === $id)>{{ $name }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-40">
                <option value="">Semua status</option>
                @foreach (\App\Models\Audit::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-filter-bar>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Proyek</th>
                        <th class="px-4 py-3">Asesor</th>
                        <th class="w-48 px-4 py-3">Proses Selesai</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Maturity</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($audits as $audit)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3">
                                <a href="{{ route('audit.show', $audit) }}" class="font-medium hover:text-brand-700">{{ $audit->name }}</a>
                                <p class="text-xs text-gray-500">Dibuat {{ $audit->created_at->translatedFormat('d M Y') }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $audit->asesor->name }}</td>
                            <td class="px-4 py-3">
                                <x-progress :value="$audit->completed_processes_count" :total="$audit->processes_count" />
                            </td>
                            <td class="px-4 py-3"><x-badge :color="$audit->status_color">{{ $audit->status_label }}</x-badge></td>
                            <td class="px-4 py-3 text-center">
                                @if ($audit->maturity_index !== null)
                                    <p class="font-semibold">{{ $audit->maturity_display }}</p>
                                    <p class="text-xs text-gray-500">Level {{ $audit->maturity_level }}</p>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :show="route('audit.show', $audit)"
                                    :edit="route('audit.edit', $audit)"
                                    :delete="route('audit.destroy', $audit)"
                                    label="proyek {{ $audit->name }}" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="6" message="Belum ada proyek audit." />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($audits->hasPages())
            <div class="border-t border-gray-100 p-4">{{ $audits->links() }}</div>
        @endif
    </x-card>
@endsection
