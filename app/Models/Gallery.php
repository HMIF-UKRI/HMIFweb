<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'member_id',
        'event_id',
        'is_featured',
        'caption',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('galery')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->quality(80)
            ->nonOptimized();
    }
}
