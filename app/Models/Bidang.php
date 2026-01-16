<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'description'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'bidang_id');
    }
}
