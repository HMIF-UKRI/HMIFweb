<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'event_date',
        'location',
        'status',
        'event_category_id',
    ];

    protected $casts = ['event_date' => 'datetime'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'period_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendances::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentEvents::class, 'event_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
}
