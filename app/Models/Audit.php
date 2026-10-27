<?php

namespace App\Models;

use App\Services\CapabilityAssessor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Proyek audit yang ditugaskan ke seorang asesor.
 */
class Audit extends Model
{
    protected $table = 'audit_projects';

    protected $fillable = ['name', 'description', 'asesor_id', 'status', 'maturity_index'];

    protected $casts = [
        'asesor_id' => 'integer',
        'maturity_index' => 'float',
    ];

    public const STATUSES = [
        'draft' => 'Draf',
        'in_progress' => 'Berjalan',
        'completed' => 'Selesai',
    ];

    public const STATUS_COLORS = [
        'draft' => 'gray',
        'in_progress' => 'amber',
        'completed' => 'green',
    ];

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(AuditProcess::class, 'project_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'project_id');
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
     * Maturity level hasil pembulatan maturity index, contoh: 2.83 -> 3.
     */
    public function getMaturityLevelAttribute(): ?int
    {
        return CapabilityAssessor::maturityLevel($this->maturity_index);
    }

    /**
     * Maturity index siap tampil, contoh: "2,8" (jumlah desimal dari config/cobit.php).
     */
    public function getMaturityDisplayAttribute(): string
    {
        return CapabilityAssessor::formatMaturity($this->maturity_index);
    }

    public function getMaturityLevelNameAttribute(): string
    {
        return CapabilityAssessor::levelName($this->maturity_level);
    }
}
