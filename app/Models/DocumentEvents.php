<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentEvents extends Model
{
    protected $fillable = [
        'event_id',
        'period_id',
        'type_document',
        'name',
        'file_path',
        'file_extension'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'periods_id');
    }
}
