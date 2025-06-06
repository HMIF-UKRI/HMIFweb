<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'event_id',
        'image_path',
        'caption',
    ];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
