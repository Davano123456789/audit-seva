<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Jawaban asesor untuk satu pertanyaan: Y (diterapkan) atau N (belum).
 */
class Answer extends Model
{
    protected $table = 'assessment_responses';

    protected $fillable = ['project_id', 'question_id', 'answer', 'notes', 'evidence_file'];

    public const YES = 'Y';
    public const NO = 'N';

    public function audit(): BelongsTo
    {
        return $this->belongsTo(Audit::class, 'project_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
