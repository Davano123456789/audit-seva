{{-- $selected: [kode proses => AuditProcess] milik proyek ini (kosong saat tambah) --}}
@php
    $oldProcesses = old('processes');
@endphp

<div class="space-y-6 p-6">
    {{-- Informasi proyek --}}
    <div>
        <h3 class="mb-4 text-sm font-semibold text-gray-700">Informasi Proyek</h3>
        <div class="grid gap-5 md:grid-cols-3">
            <div class="md:col-span-2">
                <x-form.input name="name" label="Nama Proyek" :value="$audit->name" required
                              placeholder="Contoh: Assessment Keamanan TI PT XYZ 2026" />
            </div>
            <x-form.select name="asesor_id" label="Asesor" :options="$asesorOptions" :value="$audit->asesor_id" required
                           placeholder="-- Pilih asesor --" />
        </div>
        <div class="mt-5">
            <x-form.textarea name="description" label="Deskripsi / Objek Audit" :value="$audit->description" rows="3"
                             placeholder="Contoh: Penilaian capability level pada divisi TI ..." />
        </div>
    </div>

    {{-- Pilihan proses --}}
    <div class="border-t border-gray-100 pt-6">
        <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Proses TI yang Diaudit <span class="text-red-500">*</span></h3>
                <p class="text-xs text-gray-500">Centang proses yang akan dinilai, lalu tentukan target capability level-nya.</p>
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" id="check-all" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                Pilih semua
            </label>
        </div>

        @error('processes')
            <p class="mb-3 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="space-y-4">
            @foreach ($domains as $domain)
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <div class="bg-gray-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ $domain->id }} &middot; {{ $domain->name }}
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach ($domain->processes as $process)
                            @php
                                $existing = $selected[$process->code] ?? null;
                                $locked = $existing?->isLocked() ?? false;
                                $checked = $oldProcesses !== null
                                    ? in_array($process->code, $oldProcesses, true) || $locked
                                    : $existing !== null;
                                $target = old("target_levels.{$process->code}", $existing?->target_level ?? 3);
                            @endphp

                            <div class="flex flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between" data-process-row>
                                <label class="flex flex-1 cursor-pointer items-start gap-3">
                                    <input type="checkbox" name="processes[]" value="{{ $process->code }}"
                                           class="process-check mt-0.5 h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                                           @checked($checked) @disabled($locked)>
                                    @if ($locked)
                                        {{-- Checkbox disabled tidak ikut terkirim, jadi dikirim lewat hidden input --}}
                                        <input type="hidden" name="processes[]" value="{{ $process->code }}">
                                    @endif
                                    <span>
                                        <span class="font-medium">{{ $process->code }}</span> &middot; {{ $process->name }}
                                        @if ($process->description)
                                            <span class="block text-xs text-gray-500">{{ $process->description }}</span>
                                        @endif
                                        @if ($locked)
                                            <span class="mt-1 inline-flex items-center gap-1 text-xs text-amber-700">
                                                <i data-lucide="lock" class="h-3 w-3"></i>
                                                Sudah mulai dinilai, tidak dapat dihapus dari proyek.
                                            </span>
                                        @endif
                                    </span>
                                </label>

                                <div class="flex items-center gap-2 pl-7 sm:pl-0">
                                    <label for="target-{{ $process->code }}" class="text-xs text-gray-500">Target</label>
                                    <select id="target-{{ $process->code }}" name="target_levels[{{ $process->code }}]"
                                            class="target-select rounded-lg border border-gray-300 bg-white px-2 py-1.5 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 disabled:bg-gray-100 disabled:text-gray-400">
                                        @foreach (\App\Models\AuditProcess::TARGET_LEVELS as $level)
                                            <option value="{{ $level }}" @selected((int) $target === $level)>Level {{ $level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">
    <x-button :href="route('audit.index')" variant="secondary">Batal</x-button>
    <x-button type="submit" icon="save">Simpan</x-button>
</div>

@push('scripts')
    <script>
        // Target level hanya aktif untuk proses yang dicentang
        (function () {
            const rows = document.querySelectorAll('[data-process-row]');
            const checkAll = document.getElementById('check-all');

            const sync = () => {
                let all = true;
                rows.forEach(row => {
                    const check = row.querySelector('.process-check');
                    row.querySelector('.target-select').disabled = !check.checked;
                    if (!check.checked) all = false;
                });
                checkAll.checked = all;
            };

            rows.forEach(row => row.querySelector('.process-check').addEventListener('change', sync));
            checkAll.addEventListener('change', () => {
                rows.forEach(row => {
                    const check = row.querySelector('.process-check');
                    if (!check.disabled) check.checked = checkAll.checked;
                });
                sync();
            });

            sync();
        })();
    </script>
@endpush
