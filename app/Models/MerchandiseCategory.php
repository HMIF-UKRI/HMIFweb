<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchandiseCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function merchandises(): HasMany
    {
        return $this->hasMany(Merchandise::class);
    }
}
