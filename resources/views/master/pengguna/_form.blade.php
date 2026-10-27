@php($isSelf = $pengguna->exists && $pengguna->is(auth()->user()))

<div class="space-y-6 p-6">
    {{-- Data akun --}}
    <div>
        <h3 class="mb-4 text-sm font-semibold text-gray-700">Data Akun</h3>
        <div class="grid gap-5 md:grid-cols-3">
            <x-form.input name="name" label="Nama Lengkap" :value="$pengguna->name" required />
            <x-form.input name="email" label="Email" type="email" :value="$pengguna->email" required autocomplete="off" />

            @if ($isSelf)
                <div>
                    <x-form.input name="role_display" label="Role" :value="$pengguna->role_label" disabled
                                  hint="Role akun Anda sendiri tidak dapat diubah." />
                </div>
            @else
                <x-form.select name="role" label="Role" :options="$roleOptions" :value="$pengguna->role" required />
            @endif
        </div>
        @if ($isSelf)
            <input type="hidden" name="role" value="{{ $pengguna->role }}">
        @endif
    </div>

    {{-- Kontak --}}
    <div class="border-t border-gray-100 pt-6">
        <h3 class="mb-4 text-sm font-semibold text-gray-700">Kontak</h3>
        <div class="grid gap-5 md:grid-cols-3">
            <x-form.input name="phone" label="Nomor Telepon" :value="$pengguna->phone" placeholder="08xxxxxxxxxx" />
            <div class="md:col-span-2">
                <x-form.textarea name="address" label="Alamat" :value="$pengguna->address" rows="2" />
            </div>
        </div>
    </div>

    {{-- Password --}}
    <div class="border-t border-gray-100 pt-6">
        <h3 class="mb-1 text-sm font-semibold text-gray-700">Password</h3>
        <p class="mb-4 text-xs text-gray-500">
            @if ($pengguna->exists)
                Kosongkan jika tidak ingin mengganti password.
            @else
                Minimal 8 karakter.
            @endif
        </p>
        <div class="grid gap-5 md:grid-cols-3">
            <x-form.input name="password" label="Password" type="password" :required="! $pengguna->exists" autocomplete="new-password" />
            <x-form.input name="password_confirmation" label="Ulangi Password" type="password" :required="! $pengguna->exists" autocomplete="new-password" />
        </div>
    </div>
</div>

<div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('master.pengguna.index')" variant="secondary">Batal</x-button>
    <x-button type="submit" icon="save">Simpan</x-button>
</div>
