<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location',
        'image',
        'event_categories_id',
    ];

    public function eventCategory()
    {
        return $this->belongsTo(EventCategories::class, 'event_categories_id');
    }
}
