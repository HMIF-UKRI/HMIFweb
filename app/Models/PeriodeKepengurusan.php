<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PeriodeKepengurusan extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'periods';

    protected $fillable = [
        'cabinet_name',
        'period_range',
        'vision',
        'mission',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'period_id');
    }

    public function documentEvents(): HasMany
    {
        return $this->hasMany(DocumentEvents::class, 'periods_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    protected $appends = ['preview_url'];

    public function getPreviewUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo_cabinet', 'thumb') ?: null;
    }
}
