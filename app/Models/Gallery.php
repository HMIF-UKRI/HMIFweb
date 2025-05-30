<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'events_id',
        'image_path',
        'caption',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
