<?php

namespace App\Http\Requests\Penilaian;

use Illuminate\Foundation\Http\FormRequest;

class SimpanJawabanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => ['required', 'integer'],
            'answers' => ['nullable', 'array'],
            'answers.*' => ['in:Y,N'],
            'notes' => ['nullable', 'array'],
            'notes.*' => ['nullable', 'string', 'max:2000'],
            'evidence' => ['nullable', 'array'],
            'evidence.*' => [
                'file',
                'mimes:' . implode(',', config('cobit.evidence.mimes')),
                'max:' . config('cobit.evidence.max_kb'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'answers.*' => 'jawaban',
            'notes.*' => 'bukti hasil kerja',
            'evidence.*' => 'file pendukung',
        ];
    }
}
