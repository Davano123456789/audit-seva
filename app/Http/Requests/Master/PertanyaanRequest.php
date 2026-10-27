<?php

namespace App\Http\Requests\Master;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PertanyaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'practice_code' => ['required', 'exists:cobit_practices,code'],
            'level' => ['required', 'integer', Rule::in(Question::LEVELS)],
            'question_text' => ['required', 'string'],
            'expected_evidence' => ['nullable', 'string'],
        ];
    }
}
