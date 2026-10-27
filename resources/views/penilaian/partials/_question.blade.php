{{--
    Satu pertanyaan di ruang kerja: jawaban Ya/Tidak, catatan, dan file bukti.
    Variabel: $question, $answer (Answer|null), $number
--}}
@php
    $selected = old("answers.{$question->id}", $answer?->answer);
    $note = old("notes.{$question->id}", $answer?->notes);
    $hasDetail = filled($note) || $answer?->evidence_file || $errors->has("evidence.{$question->id}");
@endphp

<div class="px-5 py-4" data-question>
    <div class="flex gap-3">
        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600">
            {{ $number }}
        </span>

        <div class="min-w-0 flex-1">
            <p class="text-sm leading-relaxed">{{ $question->question_text }}</p>
            @if ($question->expected_evidence)
                <p class="mt-1 flex items-start gap-1 text-xs text-gray-500">
                    <i data-lucide="paperclip" class="mt-0.5 h-3 w-3 shrink-0"></i>
                    Bukti: {{ $question->expected_evidence }}
                </p>
            @endif

            <div class="mt-3 flex flex-wrap items-center gap-3">
                {{-- Pilihan Ya / Tidak --}}
                <div class="inline-flex overflow-hidden rounded-lg border border-gray-300">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="answers[{{ $question->id }}]" value="Y" class="peer sr-only" @checked($selected === 'Y')>
                        <span class="flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 peer-checked:bg-brand-600 peer-checked:text-white">
                            <i data-lucide="check" class="h-4 w-4"></i> Ya
                        </span>
                    </label>
                    <label class="relative cursor-pointer border-l border-gray-300">
                        <input type="radio" name="answers[{{ $question->id }}]" value="N" class="peer sr-only" @checked($selected === 'N')>
                        <span class="flex items-center gap-1.5 px-4 py-1.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 peer-checked:bg-red-500 peer-checked:text-white">
                            <i data-lucide="x" class="h-4 w-4"></i> Tidak
                        </span>
                    </label>
                </div>

                @if ($answer?->evidence_file)
                    <a href="{{ Storage::disk('public')->url($answer->evidence_file) }}" target="_blank"
                       class="inline-flex items-center gap-1 text-xs font-medium text-sky-700 hover:underline">
                        <i data-lucide="file-check" class="h-3.5 w-3.5"></i> Bukti terunggah
                    </a>
                @endif
            </div>

            {{-- Catatan & bukti (bisa dibuka/tutup) --}}
            <details class="group mt-3" @if ($hasDetail) open @endif>
                <summary class="inline-flex cursor-pointer list-none items-center gap-1 text-xs font-medium text-gray-500 hover:text-brand-700">
                    <i data-lucide="chevron-right" class="h-3.5 w-3.5 transition group-open:rotate-90"></i>
                    Bukti hasil kerja
                </summary>

                <div class="mt-3 grid gap-3 md:grid-cols-2">
                    <div>
                        <label for="notes-{{ $question->id }}" class="mb-1 block text-xs font-medium text-gray-600">Bukti hasil kerja</label>
                        <textarea id="notes-{{ $question->id }}" name="notes[{{ $question->id }}]" rows="2"
                                  placeholder="Contoh: Dokumen kebijakan keamanan informasi dan dokumen penetapan ISMS perusahaan."
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100">{{ $note }}</textarea>
                    </div>

                    <div>
                        <label for="evidence-{{ $question->id }}" class="mb-1 block text-xs font-medium text-gray-600">File pendukung (opsional)</label>
                        <input type="file" id="evidence-{{ $question->id }}" name="evidence[{{ $question->id }}]"
                               accept="{{ collect(config('cobit.evidence.mimes'))->map(fn ($m) => '.' . $m)->implode(',') }}"
                               class="block w-full text-xs text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-xs file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                        <p class="mt-1 text-[11px] text-gray-400">
                            {{ $answer?->evidence_file ? 'Unggah file baru untuk mengganti bukti lama. ' : '' }}Maks. {{ config('cobit.evidence.max_kb') / 1024 }} MB.
                        </p>
                        @error("evidence.{$question->id}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </details>
        </div>
    </div>
</div>
