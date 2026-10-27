@php($selectedPractice = (string) old('practice_code', $pertanyaan->practice_code))

<div class="space-y-5 p-6">
    <div class="grid gap-5 md:grid-cols-3">
        {{-- Filter bantu: hanya untuk mempersempit pilihan praktik, tidak ikut disimpan --}}
        <div>
            <label for="filter-proses" class="mb-1.5 block text-sm font-medium text-gray-700">Proses TI</label>
            <select id="filter-proses"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                <option value="">Semua proses</option>
                @foreach ($processes as $process)
                    <option value="{{ $process->code }}">{{ $process->code }} - {{ $process->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="practice_code" class="mb-1.5 block text-sm font-medium text-gray-700">
                Praktik <span class="text-red-500">*</span>
            </label>
            <select id="practice_code" name="practice_code" required
                @class([
                    'w-full rounded-lg border bg-white px-3 py-2 text-sm outline-none transition focus:ring-2',
                    'border-red-400 focus:border-red-500 focus:ring-red-100' => $errors->has('practice_code'),
                    'border-gray-300 focus:border-brand-500 focus:ring-brand-100' => ! $errors->has('practice_code'),
                ])>
                <option value="">-- Pilih praktik --</option>
                @foreach ($processes as $process)
                    <optgroup label="{{ $process->code }} - {{ $process->name }}" data-process="{{ $process->code }}">
                        @foreach ($process->practices as $practice)
                            <option value="{{ $practice->code }}" @selected($selectedPractice === $practice->code)>
                                {{ $practice->code }} - {{ Str::limit($practice->name, 55) }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('practice_code')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-form.select name="level" label="Capability Level" required placeholder="-- Pilih level --"
                       :options="collect(\App\Models\Question::LEVELS)->mapWithKeys(fn ($l) => [$l => 'Level ' . $l])->all()"
                       :value="$pertanyaan->level" />
    </div>

    <x-form.textarea name="question_text" label="Pertanyaan / Aktivitas" :value="$pertanyaan->question_text" rows="4" required
                     placeholder="Contoh: Apakah perusahaan telah mengevaluasi kebutuhan staf secara teratur?" />

    <x-form.textarea name="expected_evidence" label="Bukti yang Diharapkan" :value="$pertanyaan->expected_evidence" rows="2"
                     placeholder="Contoh: Dokumen SOP rekrutmen, laporan evaluasi kebutuhan staf"
                     hint="Opsional. Dokumen atau hasil kerja yang dapat membuktikan aktivitas ini telah diterapkan." />
</div>

<div class="flex flex-wrap justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('master.pertanyaan.index')" variant="secondary">Batal</x-button>
    @unless ($pertanyaan->exists)
        <x-button type="submit" name="tambah_lagi" value="1" variant="secondary" icon="copy-plus">Simpan &amp; Tambah Lagi</x-button>
    @endunless
    <x-button type="submit" icon="save">Simpan</x-button>
</div>

@push('scripts')
    <script>
        // Saat proses dipilih, dropdown praktik hanya menampilkan praktik milik proses tersebut
        (function () {
            const filter = document.getElementById('filter-proses');
            const practice = document.getElementById('practice_code');
            const groups = practice.querySelectorAll('optgroup');

            const apply = () => {
                groups.forEach(group => {
                    const visible = !filter.value || group.dataset.process === filter.value;
                    group.hidden = !visible;
                    group.querySelectorAll('option').forEach(opt => opt.disabled = !visible);
                });

                const current = practice.selectedOptions[0];
                if (current && current.disabled) practice.value = '';
            };

            // Saat edit/validasi gagal, proses mengikuti praktik yang sudah terpilih
            const selected = practice.selectedOptions[0];
            if (selected && selected.parentElement.tagName === 'OPTGROUP') {
                filter.value = selected.parentElement.dataset.process;
            }

            filter.addEventListener('change', apply);
            apply();
        })();
    </script>
@endpush
