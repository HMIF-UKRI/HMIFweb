<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Angkatan extends Model
{
    use HasFactory;

    protected $table = 'generations';

    protected $fillable = [
        'year',
        'description',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'generation_id');
    }
}
