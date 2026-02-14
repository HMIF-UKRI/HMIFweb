<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocumentEvents;
use App\Models\Event;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocEventController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentEvents::with(['event', 'period']);

        // Filter berdasarkan Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                ->orWhereHas('event', function ($q) use ($request) {
                    $q->where('title', 'ilike', '%' . $request->search . '%');
                });
        }

        // Filter berdasarkan Periode
        if ($request->has('period_id') && $request->period_id != '') {
            $query->where('period_id', $request->period_id);
        }

        // Filter berdasarkan Tipe Dokumen
        if ($request->has('type') && $request->type != '') {
            $query->where('type_document', $request->type);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        $periods = PeriodeKepengurusan::lazy();

        $events = Event::orderBy('title')->get();

        return view('admin.doc-event.index', compact('documents', 'periods', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'      => 'required|exists:events,id',
            'file'          => 'required|mimes:pdf|max:20480',
            'type_document' => 'required|in:proposal,lpj',
        ]);

        return DB::transaction(function () use ($request, $validated) {

            $event = Event::findOrFail($validated['event_id']);

            $document = DocumentEvents::create([
                'event_id'      => $event->id,
                'period_id'     => $event->period_id,
                'type_document' => $validated['type_document'],
                'name'          => "Arsip_" . ucfirst($validated['type_document']) . "_" . $event->title,
            ]);

            $fileName = Str::slug($document->name) . '-' . now()->format('YmdHis');

            $document->addMediaFromRequest('file')
                ->usingFileName($fileName . '.pdf')
                ->toMediaCollection('pdf_archive');

            return back()->with('success', 'Dokumen berhasil diarsipkan secara aman.');
        });
    }

    public function download($id)
    {
        if (!auth()->user()->hasAnyRole(['super-admin', 'pengurus'])) {
            abort(403, 'Anda tidak memiliki akses ke dokumen internal.');
        }

        $document = DocumentEvents::findOrFail($id);
        $media = $document->getFirstMedia('pdf_archive');

        if (!$media) {
            return back()->with('error', 'File fisik tidak ditemukan.');
        }

        return response()->download($media->getPath(), $media->file_name);
    }

    public function view(DocumentEvents $document)
    {
        $media = $document->getFirstMedia('pdf_archive');

        if (!$media) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($media->getPath(), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]);
    }

    public function destroy($id)
    {
        $document = DocumentEvents::findOrFail($id);
        $document->delete();

        return redirect()->back()->with('success', 'Arsip dokumen berhasil dihapus secara permanen.');
    }
}
