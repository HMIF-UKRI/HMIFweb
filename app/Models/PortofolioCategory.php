<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortofolioCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function portofolios(): HasMany
    {
        return $this->hasMany(Portofolio::class, 'portofolio_category_id');
    }
}
