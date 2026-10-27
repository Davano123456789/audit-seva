<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProsesRequest extends FormRequest
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
            'domain_id' => ['required', 'exists:cobit_domains,id'],
            'code' => [
                'required', 'string', 'regex:/^[A-Z]+[0-9]{2}$/',
                Rule::unique('cobit_processes', 'code')->ignore($this->route('proses')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.regex' => 'Format kode proses tidak valid, contoh: APO07.',
        ];
    }
}
