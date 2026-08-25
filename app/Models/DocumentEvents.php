<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DocumentEvents extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'period_id',
        'user_id',
        'type_document',
        'name',
        'description',
        'access_level',
        'file_extension',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    protected static function booted(): void
    {
        static::deleting(function ($document) {
            $document->clearMediaCollection('doc_archives');
            $document->clearMediaCollection('pdf_archive');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('doc_archives')
            ->useDisk('archives')
            ->singleFile()
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
                'text/plain',
            ]);

        $this->addMediaCollection('pdf_archive')
            ->useDisk('archives')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    public function getArchiveMedia(): ?Media
    {
        return $this->getFirstMedia('doc_archives') ?: $this->getFirstMedia('pdf_archive');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodeKepengurusan::class, 'period_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if (!$bytes) {
            $media = $this->getArchiveMedia();
            $bytes = $media ? $media->size : 0;
        }

        if ($bytes <= 0) return '0 KB';

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        $val = round($bytes / pow(1024, $i), 2);

        return $val . ' ' . ($units[$i] ?? 'MB');
    }

    public function getIsPdfAttribute(): bool
    {
        $ext = strtolower($this->file_extension ?? '');
        if (!$ext && $media = $this->getArchiveMedia()) {
            $ext = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
        }
        return $ext === 'pdf';
    }

    public function getIsWordAttribute(): bool
    {
        $ext = strtolower($this->file_extension ?? '');
        if (!$ext && $media = $this->getArchiveMedia()) {
            $ext = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
        }
        return in_array($ext, ['doc', 'docx']);
    }

    public function getIsExcelAttribute(): bool
    {
        $ext = strtolower($this->file_extension ?? '');
        if (!$ext && $media = $this->getArchiveMedia()) {
            $ext = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
        }
        return in_array($ext, ['xls', 'xlsx', 'csv']);
    }

    public function getFileIconAttribute(): string
    {
        if ($this->is_pdf) {
            return 'fa-solid fa-file-pdf text-red-500';
        }
        if ($this->is_word) {
            return 'fa-solid fa-file-word text-blue-500';
        }
        if ($this->is_excel) {
            return 'fa-solid fa-file-excel text-emerald-500';
        }
        return 'fa-solid fa-file-lines text-gray-400';
    }

    public function getTypeDocumentLabelAttribute(): string
    {
        return match ($this->type_document) {
            'proposal'  => 'PROPOSAL',
            'lpj'       => 'LPJ',
            'rab'       => 'RAB / KEUANGAN',
            'surat'     => 'SURAT RESMI',
            'tor'       => 'TOR / JUKLAK',
            'notulensi' => 'NOTULENSI',
            default     => 'DOKUMEN LAIN',
        };
    }

    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type_document) {
            'proposal'  => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'lpj'       => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'rab'       => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
            'surat'     => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            'tor'       => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
            'notulensi' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
            default     => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
        };
    }
}
