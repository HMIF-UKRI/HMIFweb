<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Portofolio extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'portofolio_category_id',
        'member_id',
        'title',
        'slug',
        'description',
        'is_featured',
        'url_github',
        'url_linkedin',
        'status'
    ];
    protected $casts = [
        'is_featured' => 'boolean'
    ];

    public function portofolioCategory(): BelongsTo
    {
        return $this->belongsTo(PortofolioCategory::class, 'portofolio_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->quality(80)
            ->nonOptimized();
    }
}
