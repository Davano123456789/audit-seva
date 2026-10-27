<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    protected $table = 'cobit_domains';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'description'];

    public function processes(): HasMany
    {
        return $this->hasMany(ItProcess::class, 'domain_id');
    }
}
