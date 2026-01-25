<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'blog_category_id',
        'title',
        'slug',
        'summary',
        'content',
        'views_count',
        'status'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Registrasi Koleksi Media (Spatie)
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('blog_thumbnails')
            ->singleFile();
    }

    /**
     * Konversi Media untuk Thumbnail
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(800)
            ->height(450)
            ->sharpen(10)
            ->nonOptimized();
    }
}
