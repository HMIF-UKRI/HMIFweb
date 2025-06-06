<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'thumbnail_path',
        'event_date',
        'location',
        'status',
        'event_category_id',
    ];

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
