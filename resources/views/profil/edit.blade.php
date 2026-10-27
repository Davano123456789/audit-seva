@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <x-page-header title="Profil Saya" subtitle="Perbarui data diri, foto, dan password akun Anda." />

    <div class="grid gap-6 xl:grid-cols-3">
        {{-- Data profil --}}
        <x-card class="xl:col-span-2">
            <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        @if ($user->photo_url)
                            <img src="{{ $user->photo_url }}" alt="Foto {{ $user->name }}" class="h-20 w-20 rounded-full object-cover ring-4 ring-brand-50">
                        @else
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-brand-100 text-2xl font-bold text-brand-700 ring-4 ring-brand-50">
                                {{ $user->initials }}
                            </div>
                        @endif

                        <div class="space-y-2">
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                   class="block text-sm text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                            <p class="text-xs text-gray-500">JPG, PNG, atau WEBP, maksimal 2 MB.</p>
                            @if ($user->photo)
                                <label class="flex items-center gap-2 text-xs text-gray-600">
                                    <input type="checkbox" name="remove_photo" value="1" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    Hapus foto
                                </label>
                            @endif
                            @error('photo')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <x-form.input name="name" label="Nama Lengkap" :value="$user->name" required />
                        <x-form.input name="email" label="Email" type="email" :value="$user->email" required />
                        <x-form.input name="phone" label="Nomor Telepon" :value="$user->phone" placeholder="08xxxxxxxxxx" />
                        <div>
                            <p class="mb-1.5 block text-sm font-medium text-gray-700">Role</p>
                            <p class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600">{{ $user->role_label }}</p>
                        </div>
                    </div>

                    <x-form.textarea name="address" label="Alamat" :value="$user->address" rows="2" />
                </div>

                <div class="flex justify-end border-t border-gray-100 px-6 py-4">
                    <x-button type="submit" icon="save">Simpan Profil</x-button>
                </div>
            </form>
        </x-card>

        {{-- Ganti password (error-nya memakai error bag "password") --}}
        <x-card>
            <form method="POST" action="{{ route('profil.password') }}">
                @csrf
                @method('PUT')

                <div class="space-y-5 p-6">
                    <div>
                        <h3 class="font-semibold">Ganti Password</h3>
                        <p class="text-xs text-gray-500">Minimal 8 karakter dan berbeda dari password lama.</p>
                    </div>

                    @foreach ([
                        'current_password' => ['Password Saat Ini', 'current-password'],
                        'password' => ['Password Baru', 'new-password'],
                        'password_confirmation' => ['Ulangi Password Baru', 'new-password'],
                    ] as $field => [$label, $autocomplete])
                        <div>
                            <label for="{{ $field }}" class="mb-1.5 block text-sm font-medium text-gray-700">{{ $label }} <span class="text-red-500">*</span></label>
                            <input id="{{ $field }}" name="{{ $field }}" type="password" required autocomplete="{{ $autocomplete }}"
                                   @class([
                                       'w-full rounded-lg border px-3 py-2 text-sm outline-none transition focus:ring-2',
                                       'border-red-400 focus:border-red-500 focus:ring-red-100' => $errors->password->has($field),
                                       'border-gray-300 focus:border-brand-500 focus:ring-brand-100' => ! $errors->password->has($field),
                                   ])>
                            @if ($errors->password->has($field))
                                <p class="mt-1 text-xs text-red-600">{{ $errors->password->first($field) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end border-t border-gray-100 px-6 py-4">
                    <x-button type="submit" icon="key-round">Ganti Password</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
