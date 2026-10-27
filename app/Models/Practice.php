<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Management practice COBIT 2019, contoh: APO07.01.
 */
class Practice extends Model
{
    protected $table = 'cobit_practices';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['code', 'process_code', 'name', 'description'];

    public function process(): BelongsTo
    {
        return $this->belongsTo(ItProcess::class, 'process_code');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'practice_code');
    }
}
