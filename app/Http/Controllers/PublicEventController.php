<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\RegisterEventRequest;
use App\Models\Event;
use App\Models\EventCategory;
use App\Services\Event\EventRegistrationService;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function __construct(
        protected EventRegistrationService $registrationService
    ) {
    }

    public function index(Request $request)
    {
        $events = Event::with('category', 'media')->latest()->get()->map(function ($event) {
            $event->thumbnail_url = $event->getFirstMediaUrl('thumbnails', 'thumb');
            return $event;
        });

        $eventCategories = EventCategory::lazy();

        return view('page.kegiatan', compact('events', 'eventCategories'));
    }

    public function show($slug)
    {
        $event = Event::with(['category', 'period', 'media'])
            ->withCount('registrations')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedEvents = Event::with(['category', 'media'])
            ->where('event_category_id', $event->event_category_id)
            ->where('id', '!=', $event->id)
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->limit(3)
            ->get();

        return view('page.event.show', compact('event', 'relatedEvents'));
    }

    public function register(RegisterEventRequest $request, $slug)
    {
        $event = Event::with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $result = $this->registrationService->register(
            event: $event,
            data: $request->validated(),
            user: $request->user()
        );

        if ($result['status'] === 'closed') {
            return redirect()
                ->route('event.show', $event->slug)
                ->with('error', $result['message']);
        }

        if ($result['status'] === 'already_registered') {
            return redirect()
                ->route('event.show', $event->slug)
                ->with('info', $result['message']);
        }

        $registration = $result['registration'];
        $redirect = redirect()->route('event.show', $event->slug)
            ->with('registration_success', [
                'full_name'           => $registration->full_name,
                'email'               => $registration->email,
                'email_sent'          => $result['email_sent'],
                'whatsapp_group_link' => $result['whatsapp_group_link'],
            ]);

        if ($result['email_sent']) {
            return $redirect->with('success', 'Pendaftaran / absensi berhasil dicatat. Informasi resmi sudah dikirim ke email.');
        }

        return $redirect->with('warning', 'Pendaftaran / absensi berhasil disimpan. (Konfigurasi pengiriman email sedang diproses)');
    }
}
