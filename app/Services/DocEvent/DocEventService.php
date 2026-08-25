<?php

namespace App\Services\DocEvent;

use App\Models\DocumentEvents;
use App\Models\Event;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class DocEventService
{
    /**
     * Get paginated documents with multi-criteria filtering.
     */
    public function getAllDocuments(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = DocumentEvents::with(['event', 'period', 'user', 'media']);

        // 1. Keyword search (Name, Description, or Event Title)
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('event', function ($eq) use ($search) {
                      $eq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter by Period
        if (!empty($filters['period_id'])) {
            $query->where('period_id', $filters['period_id']);
        }

        // 3. Filter by Document Type (proposal, lpj, rab, surat, tor, notulensi, lainnya)
        if (!empty($filters['type'])) {
            $query->where('type_document', $filters['type']);
        }

        // 4. Filter by File Format (pdf, word, excel)
        if (!empty($filters['format'])) {
            $format = strtolower($filters['format']);
            if ($format === 'pdf') {
                $query->where('file_extension', 'pdf');
            } elseif ($format === 'word') {
                $query->whereIn('file_extension', ['doc', 'docx']);
            } elseif ($format === 'excel') {
                $query->whereIn('file_extension', ['xls', 'xlsx', 'csv']);
            }
        }

        // 5. Filter by specific Event
        if (!empty($filters['event_id'])) {
            $query->where('event_id', $filters['event_id']);
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    /**
     * Store new document archive.
     */
    public function storeDocument(array $data, UploadedFile $file, ?int $userId): DocumentEvents
    {
        return DB::transaction(function () use ($data, $file, $userId) {
            $event = !empty($data['event_id']) ? Event::find($data['event_id']) : null;
            $periodId = $data['period_id'] ?? ($event ? $event->period_id : PeriodeKepengurusan::where('is_current', true)->value('id'));

            $extension = strtolower($file->getClientOriginalExtension());
            $fileSize = $file->getSize();

            // Auto-standardized document name if not provided
            $docName = $data['name'];
            if (empty($docName)) {
                $prefix = strtoupper($data['type_document']);
                $suffix = $event ? $event->title : 'Umum';
                $docName = "Arsip_{$prefix}_{$suffix}";
            }

            $document = DocumentEvents::create([
                'event_id'       => $event?->id,
                'period_id'      => $periodId,
                'user_id'        => $userId,
                'type_document'  => $data['type_document'],
                'name'           => $docName,
                'description'    => $data['description'] ?? null,
                'access_level'   => $data['access_level'] ?? 'internal',
                'file_extension' => $extension,
                'file_size'      => $fileSize,
            ]);

            // Standardize physical file name
            $sanitizedName = Str::slug($document->name);
            $finalFileName = "{$sanitizedName}-" . now()->format('YmdHis') . ".{$extension}";

            $document->addMedia($file)
                ->usingFileName($finalFileName)
                ->toMediaCollection('doc_archives');

            return $document;
        });
    }

    /**
     * Delete document and its associated media.
     */
    public function deleteDocument(DocumentEvents $document): bool
    {
        return DB::transaction(function () use ($document) {
            $document->clearMediaCollection('doc_archives');
            $document->clearMediaCollection('pdf_archive');
            return $document->delete();
        });
    }

    /**
     * Return secure binary download response.
     */
    public function getDownloadResponse(DocumentEvents $document): BinaryFileResponse
    {
        $media = $document->getArchiveMedia();

        if (!$media || !file_exists($media->getPath())) {
            abort(404, 'Berkas fisik arsip tidak ditemukan pada server.');
        }

        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * Return inline preview response (for PDF).
     */
    public function getInlinePdfResponse(DocumentEvents $document)
    {
        $media = $document->getArchiveMedia();

        if (!$media || !file_exists($media->getPath())) {
            abort(404, 'Berkas arsip tidak ditemukan.');
        }

        return response()->file($media->getPath(), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
        ]);
    }

    /**
     * Export all documents of an event into a ZIP archive.
     */
    public function exportEventDocumentsAsZip(Event $event): BinaryFileResponse
    {
        $documents = DocumentEvents::where('event_id', $event->id)->get();

        if ($documents->isEmpty()) {
            abort(404, 'Tidak ada dokumen arsip yang terhubung dengan kegiatan ini.');
        }

        $zipFileName = 'Arsip_' . Str::slug($event->title) . '_' . now()->format('Ymd') . '.zip';
        $tempDir = storage_path('app/temp');

        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat file ZIP arsip.');
        }

        foreach ($documents as $doc) {
            $media = $doc->getArchiveMedia();
            if ($media && file_exists($media->getPath())) {
                $entryName = strtoupper($doc->type_document) . '_' . $media->file_name;
                $zip->addFile($media->getPath(), $entryName);
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Calculate archive metrics for top KPI summary cards.
     */
    public function getArchiveMetrics(?int $periodId = null): array
    {
        $query = DocumentEvents::query();

        if ($periodId) {
            $query->where('period_id', $periodId);
        }

        $totalDocs = (clone $query)->count();
        $totalBytes = (clone $query)->sum('file_size') ?: 0;
        $totalProposals = (clone $query)->where('type_document', 'proposal')->count();
        $totalLpj = (clone $query)->where('type_document', 'lpj')->count();
        $totalRab = (clone $query)->where('type_document', 'rab')->count();

        // If file_size was not populated on legacy records, calculate from media
        if ($totalBytes === 0 && $totalDocs > 0) {
            $totalBytes = DB::table('media')
                ->whereIn('collection_name', ['doc_archives', 'pdf_archive'])
                ->sum('size') ?: 0;
        }

        return [
            'total_documents' => $totalDocs,
            'total_size_formatted' => $this->formatBytes($totalBytes),
            'total_proposals' => $totalProposals,
            'total_lpj' => $totalLpj,
            'total_rab' => $totalRab,
        ];
    }

    /**
     * Format bytes to readable size string.
     */
    public function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) return '0 MB';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        $val = round($bytes / pow(1024, $i), 2);

        return $val . ' ' . ($units[$i] ?? 'MB');
    }
}
