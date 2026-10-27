@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <x-page-header title="Pengguna" subtitle="Kelola akun administrator dan asesor yang dapat mengakses sistem.">
        <x-slot:actions>
            <x-button :href="route('master.pengguna.create')" icon="user-plus">Tambah Pengguna</x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <x-filter-bar :action="route('master.pengguna.index')" placeholder="Cari nama atau email...">
            <select name="role" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 sm:w-44">
                <option value="">Semua role</option>
                @foreach ($roleOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-filter-bar>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Telepon</th>
                        <th class="px-4 py-3 text-center">Proyek Audit</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50/60">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700">
                                        {{ $user->initials }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium">
                                            {{ $user->name }}
                                            @if ($user->is(auth()->user()))
                                                <span class="text-xs font-normal text-gray-400">(Anda)</span>
                                            @endif
                                        </p>
                                        <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <x-badge :color="$user->isAdmin() ? 'amber' : 'blue'">{{ $user->role_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $user->isAsesor() ? $user->audits_count : '-' }}</td>
                            <td class="px-4 py-3">
                                <x-table.actions
                                    :edit="route('master.pengguna.edit', $user)"
                                    :delete="route('master.pengguna.destroy', $user)"
                                    label="pengguna {{ $user->name }}" />
                            </td>
                        </tr>
                    @empty
                        <x-table.empty colspan="5" message="Tidak ada pengguna yang ditemukan." />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-gray-100 p-4">{{ $users->links() }}</div>
        @endif
    </x-card>
@endsection
