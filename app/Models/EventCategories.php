<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategories extends Model
{
    protected $table = 'event_categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
