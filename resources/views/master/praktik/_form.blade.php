<div class="space-y-5 p-6">
    <div class="grid gap-5 sm:grid-cols-2">
        <x-form.select name="process_code" label="Proses TI" :options="$processOptions" :value="$praktik->process_code" required />
        <x-form.input name="code" label="Kode Praktik" :value="$praktik->code" required maxlength="15"
                      placeholder="APO07.01" hint="Contoh: APO07.01." />
    </div>

    <x-form.input name="name" label="Nama Praktik (COBIT)" :value="$praktik->name" required
                  placeholder="Acquire and maintain adequate and appropriate staffing" />

    <x-form.textarea name="description" label="Deskripsi dalam Bahasa Indonesia" :value="$praktik->description" rows="3" />
</div>

<div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('master.praktik.index')" variant="secondary">Batal</x-button>
    <x-button type="submit" icon="save">Simpan</x-button>
</div>
