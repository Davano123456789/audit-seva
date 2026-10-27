<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Pertanyaan/aktivitas yang dinilai pada capability level tertentu (2 - 5).
 */
class Question extends Model
{
    protected $table = 'cobit_questions';

    protected $fillable = ['practice_code', 'level', 'question_text', 'expected_evidence'];

    protected $casts = [
        'level' => 'integer',
    ];

    public const LEVELS = [2, 3, 4, 5];

    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class, 'practice_code');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
