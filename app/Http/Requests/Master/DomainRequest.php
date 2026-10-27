<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => strtoupper(trim((string) $this->id))]);
    }

    public function rules(): array
    {
        return [
            'id' => [
                'required', 'string', 'max:10', 'regex:/^[A-Z]+$/',
                Rule::unique('cobit_domains', 'id')->ignore($this->route('domain')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.regex' => 'Kode domain hanya boleh huruf, contoh: APO.',
        ];
    }
}
