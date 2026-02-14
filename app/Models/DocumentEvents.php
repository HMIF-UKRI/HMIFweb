<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DocumentEvents extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'period_id',
        'type_document',
        'name',
    ];

    protected static function booted()
    {
        static::deleting(function ($document) {
            $document->clearMediaCollection('pdf_archive');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pdf_archive')
            ->useDisk('archives')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'period_id');
    }
}
