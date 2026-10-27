<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PraktikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['code' => strtoupper(trim((string) $this->code))]);
    }

    public function rules(): array
    {
        return [
            'process_code' => ['required', 'exists:cobit_processes,code'],
            'code' => [
                'required', 'string', 'regex:/^[A-Z]+[0-9]{2}\.[0-9]{2}$/',
                Rule::unique('cobit_practices', 'code')->ignore($this->route('praktik')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.regex' => 'Format kode praktik tidak valid, contoh: APO07.01.',
        ];
    }
}
