<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        'show_on_homepage',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'period_id');
    }

    public function documentEvents(): HasMany
    {
        return $this->hasMany(DocumentEvents::class, 'periods_id');
    }
}
