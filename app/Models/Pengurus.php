<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Pengurus extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'pengurus';
    protected $fillable = [
        'member_id',
        'period_id',
        'department_id',
        'bidang_id',
        'hierarchy_level',
        'position'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'period_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'department_id');
    }

    // Relasi ke bidang (Nullable untuk Kepala Departemen)
    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->width(600)
            ->height(800)
            ->sharpen(10)
            ->quality(80)
            ->nonOptimized();
    }
}
