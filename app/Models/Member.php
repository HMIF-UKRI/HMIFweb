<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Member extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'members';

    protected $fillable = [
        'user_id',
        'department_id',
        'generation_id',
        'full_name',
        'npm',
        'is_active',
        'instagram_url',
        'linkedin_url',
    ];

    protected $appends = ['preview_url'];

    public function getPreviewUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatars', 'thumb') ?: null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'department_id');
    }

    public function generation(): BelongsTo
    {
        return $this->belongsTo(Angkatan::class, 'generation_id');
    }

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'member_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendances::class, 'member_id');
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
