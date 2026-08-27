<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\SendCertificateRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRegistrationRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\Event\UploadEventImageRequest;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\PeriodeKepengurusan;
use App\Services\Event\EventCertificateService;
use App\Services\Event\EventRegistrationService;
use App\Services\Event\EventService;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    public function __construct(
        protected EventService $eventService,
        protected EventRegistrationService $registrationService,
        protected EventCertificateService $certificateService
    ) {
    }

    public function index(Request $request)
    {
        $query = Event::with('category', 'media');

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(short_description) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('event_category_id', $request->category_id);
        }

        $events = $query->latest()->paginate(9);
        $categories = EventCategory::all();

        return view('admin.event.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        $periods = PeriodeKepengurusan::all();

        return view('admin.event.create', compact('categories', 'periods'));
    }

    public function store(StoreEventRequest $request)
    {
        try {
            $this->eventService->createEvent(
                data: $request->validated(),
                thumbnail: $request->file('thumbnail'),
                user: $request->user()
            );

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event berhasil diterbitkan.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->with(['category', 'period', 'media'])
            ->withCount(['registrations'])
            ->firstOrFail();

        $registrationSearch = trim((string) request('registration_search'));

        $registrations = $event->registrations()
            ->when($registrationSearch !== '', function ($query) use ($registrationSearch) {
                $query->where(function ($subQuery) use ($registrationSearch) {
                    $subQuery->where('full_name', 'like', "%{$registrationSearch}%")
                        ->orWhere('email', 'like', "%{$registrationSearch}%")
                        ->orWhere('phone', 'like', "%{$registrationSearch}%")
                        ->orWhere('institution', 'like', "%{$registrationSearch}%");
                });
            })
            ->latest()
            ->paginate(20, ['*'], 'registrations_page')
            ->withQueryString()
            ->fragment('pendaftaran');

        $demographics = $this->registrationService->summarizeDemographics($event);
        $registrationCategories = $demographics['categories'];
        $batchSummary = $demographics['batches'];

        return view('admin.event.show', compact(
            'event',
            'registrations',
            'registrationCategories',
            'batchSummary',
            'registrationSearch'
        ));
    }

    public function qrcode($slug)
    {
        $event = Event::where('slug', $slug)
            ->with(['category', 'period', 'media'])
            ->firstOrFail();

        $scanUrl = route('attendance.scan', $event->slug);

        return view('admin.event.qrcode', compact('event', 'scanUrl'));
    }

    public function exportRegistrations($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return $this->registrationService->exportCsv($event);
    }

    public function updateRegistration(UpdateEventRegistrationRequest $request, $slug, EventRegistration $registration)
    {
        $event = $this->findRegistrationEvent($slug, $registration);

        $this->registrationService->updateRegistration($registration, $request->validated());

        return redirect()
            ->back()
            ->withFragment('pendaftaran')
            ->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    public function destroyRegistration($slug, EventRegistration $registration)
    {
        $event = $this->findRegistrationEvent($slug, $registration);

        $this->registrationService->deleteRegistration($registration);

        return redirect()
            ->back()
            ->withFragment('pendaftaran')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function sendRegistrationCertificate(SendCertificateRequest $request, $slug, EventRegistration $registration)
    {
        $event = $this->findRegistrationEvent($slug, $registration);

        try {
            $this->certificateService->sendSingleCertificate(
                event: $event,
                registration: $registration,
                validated: $request->validated(),
                file: $request->file('certificate_file')
            );
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->withFragment('pendaftaran')
                ->with('error', 'Sertifikat gagal dikirim. Cek konfigurasi email atau file sertifikat.');
        }

        return redirect()
            ->back()
            ->withFragment('pendaftaran')
            ->with('success', 'Sertifikat berhasil dikirim ke ' . $registration->full_name . '.');
    }

    public function sendAllRegistrationCertificates(SendCertificateRequest $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $result = $this->certificateService->sendBulkCertificates(
            event: $event,
            validated: $request->validated(),
            file: $request->file('certificate_file')
        );

        $sent = $result['sent'];
        $failed = $result['failed'];

        if ($failed > 0) {
            return redirect()
                ->back()
                ->withFragment('pendaftaran')
                ->with('warning', "Sertifikat terkirim ke {$sent} peserta, gagal {$failed} peserta.");
        }

        return redirect()
            ->back()
            ->withFragment('pendaftaran')
            ->with('success', "Sertifikat berhasil dikirim ke {$sent} peserta.");
    }

    public function edit($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $categories = EventCategory::all();
        $periods = PeriodeKepengurusan::all();

        return view('admin.event.edit', compact('event', 'categories', 'periods'));
    }

    public function update(UpdateEventRequest $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $this->eventService->updateEvent(
            event: $event,
            data: $request->validated(),
            thumbnail: $request->file('thumbnail')
        );

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Data event berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $this->eventService->deleteEvent($event);

        return redirect()->back()->with('success', 'Event berhasil dihapus.');
    }

    public function uploadImage(UploadEventImageRequest $request)
    {
        try {
            $result = $this->eventService->uploadEditorImage($request->file('image'));

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function findRegistrationEvent(string $slug, EventRegistration $registration): Event
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        abort_unless((int) $registration->event_id === (int) $event->id, 404);

        return $event;
    }
}
