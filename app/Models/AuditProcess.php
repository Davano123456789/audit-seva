<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Proses TI yang termasuk dalam ruang lingkup sebuah audit.
 */
class AuditProcess extends Model
{
    protected $table = 'audit_project_processes';

    protected $fillable = ['project_id', 'process_code', 'target_level', 'computed_capability_level', 'status'];

    protected $casts = [
        'target_level' => 'integer',
        'computed_capability_level' => 'integer',
    ];

    public const STATUSES = [
        'not_started' => 'Belum Dimulai',
        'in_progress' => 'Sedang Dinilai',
        'completed' => 'Selesai',
    ];

    public const STATUS_COLORS = [
        'not_started' => 'gray',
        'in_progress' => 'amber',
        'completed' => 'green',
    ];

    /** Pilihan target capability level saat membuat proyek */
    public const TARGET_LEVELS = [1, 2, 3, 4, 5];

    public function audit(): BelongsTo
    {
        return $this->belongsTo(Audit::class, 'project_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(ItProcess::class, 'process_code');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    /**
     * Proses yang sudah mulai dinilai tidak boleh dikeluarkan dari proyek.
     */
    public function isLocked(): bool
    {
        return $this->status !== 'not_started';
    }
}
