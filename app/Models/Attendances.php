<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendances extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'event_id',
        'member_id',
        'check_in_time',
        'is_present',
        'participant_type',
        'external_name',
        'external_npm',
        'external_prodi',
        'external_angkatan'
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'is_present' => 'boolean'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeInternal($query)
    {
        return $query->where('participant_type', 'internal');
    }
}
