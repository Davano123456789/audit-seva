<div class="space-y-5 p-6">
    <div class="grid gap-5 sm:grid-cols-3">
        <x-form.input name="id" label="Kode Domain" :value="$domain->id" required maxlength="10"
                      placeholder="APO" hint="Huruf kapital, contoh: APO, BAI, DSS." />
        <div class="sm:col-span-2">
            <x-form.input name="name" label="Nama Domain" :value="$domain->name" required
                          placeholder="Align, Plan and Organize" />
        </div>
    </div>

    <x-form.textarea name="description" label="Deskripsi" :value="$domain->description" rows="4" />
</div>

<div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('master.domain.index')" variant="secondary">Batal</x-button>
    <x-button type="submit" icon="save">Simpan</x-button>
</div>
