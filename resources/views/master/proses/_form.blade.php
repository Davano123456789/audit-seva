<div class="space-y-5 p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.select name="domain_id" label="Domain" :options="$domainOptions" :value="$proses->domain_id" required />
        <x-form.input name="code" label="Kode Proses" :value="$proses->code" required maxlength="10"
                      placeholder="APO07" hint="Contoh: APO07." />
    </div>

    <x-form.input name="name" label="Nama Proses (COBIT)" :value="$proses->name" required
                  placeholder="Managed Human Resources" />

    <x-form.textarea name="description" label="Nama/Deskripsi dalam Bahasa Indonesia" :value="$proses->description"
                     rows="3" placeholder="Pengelolaan SDM TI" />
</div>

<div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('master.proses.index')" variant="secondary">Batal</x-button>
    <x-button type="submit" icon="save">Simpan</x-button>
</div>
