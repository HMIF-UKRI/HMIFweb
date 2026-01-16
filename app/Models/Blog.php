<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'member_id',
        'blog_category_id',
        'title',
        'slug',
        'summary',
        'views_count',
        'status'
    ];

    public function author()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'id_blog_category');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->nonOptimized();
    }
}
