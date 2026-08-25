<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocEvent\StoreDocEventRequest;
use App\Models\DocumentEvents;
use App\Models\Event;
use App\Models\PeriodeKepengurusan;
use App\Services\DocEvent\DocEventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocEventController extends Controller
{
    public function __construct(
        protected DocEventService $docEventService
    ) {}

    /**
     * Display a listing of archive documents with filter & metrics.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'period_id', 'type', 'format', 'event_id']);
        $documents = $this->docEventService->getAllDocuments($filters, 10);

        $selectedPeriodId = $request->filled('period_id') ? (int) $request->period_id : null;
        $metrics = $this->docEventService->getArchiveMetrics($selectedPeriodId);

        $periods = PeriodeKepengurusan::orderByDesc('is_current')->orderByDesc('start_date')->get();
        $events = Event::orderBy('title')->get();

        return view('admin.doc-event.index', compact(
            'documents',
            'periods',
            'events',
            'metrics',
            'filters'
        ));
    }

    /**
     * Store a newly created document in archive.
     */
    public function store(StoreDocEventRequest $request): RedirectResponse
    {
        try {
            $this->docEventService->storeDocument(
                $request->validated(),
                $request->file('file'),
                auth()->id()
            );

            return redirect()->route('admin.doc-event.index')
                ->with('success', 'Dokumen berhasil diarsipkan secara aman.');
        } catch (\Throwable $e) {
            report($e);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengarsipkan dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Download document file.
     */
    public function download(int $id): BinaryFileResponse
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'pengurus'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh dokumen internal ini.');
        }

        $document = DocumentEvents::findOrFail($id);
        return $this->docEventService->getDownloadResponse($document);
    }

    /**
     * View PDF document inline.
     */
    public function view(int $id)
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'pengurus'])) {
            abort(403, 'Akses ditolak.');
        }

        $document = DocumentEvents::findOrFail($id);
        return $this->docEventService->getInlinePdfResponse($document);
    }

    /**
     * Export all documents of an event into a single ZIP file.
     */
    public function exportZip(int $eventId): BinaryFileResponse
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'pengurus'])) {
            abort(403, 'Akses ditolak.');
        }

        $event = Event::findOrFail($eventId);
        return $this->docEventService->exportEventDocumentsAsZip($event);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $document = DocumentEvents::findOrFail($id);
        $this->docEventService->deleteDocument($document);

        return redirect()->back()->with('success', 'Arsip dokumen berhasil dihapus secara permanen.');
    }
}
