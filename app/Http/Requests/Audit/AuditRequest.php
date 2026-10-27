<?php

namespace App\Http\Requests\Audit;

use App\Models\AuditProcess;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'asesor_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_ASESOR)],
            'processes' => ['required', 'array', 'min:1'],
            'processes.*' => ['distinct', 'exists:cobit_processes,code'],
            'target_levels' => ['nullable', 'array'],
            'target_levels.*' => ['integer', Rule::in(AuditProcess::TARGET_LEVELS)],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama proyek',
            'asesor_id' => 'asesor',
            'processes' => 'proses TI',
            'target_levels.*' => 'target level',
        ];
    }

    public function messages(): array
    {
        return [
            'processes.required' => 'Pilih minimal 1 proses TI yang akan diaudit.',
        ];
    }

    /**
     * Target level untuk sebuah proses, default 3 jika tidak diisi.
     */
    public function targetLevelFor(string $processCode): int
    {
        return (int) ($this->input("target_levels.{$processCode}") ?: 3);
    }
}
