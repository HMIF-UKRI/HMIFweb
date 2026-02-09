<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Merchandise extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'merchandises';

    protected $fillable = [
        'name',
        'price',
        'original_price',
        'image',
        'description',
        'stock',
        'is_new',
        'material',
        'size',
        'color',
        'merchandise_category_id'
    ];

    protected $casts = [
        'is_new' => 'boolean',
    ];

    protected $appends = ['preview_url'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MerchandiseCategory::class, 'merchandise_category_id');
    }

    public function getPreviewUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('merchandises', 'thumb') ?: null;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->quality(80)
            ->nonOptimized();
    }
}
