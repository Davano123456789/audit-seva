<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Proses TI COBIT 2019, contoh: APO07 Managed Human Resources.
 */
class ItProcess extends Model
{
    protected $table = 'cobit_processes';
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['code', 'domain_id', 'name', 'description'];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function practices(): HasMany
    {
        return $this->hasMany(Practice::class, 'process_code');
    }

    public function auditProcesses(): HasMany
    {
        return $this->hasMany(AuditProcess::class, 'process_code');
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, Practice::class, 'process_code', 'practice_code', 'code', 'code');
    }
}
