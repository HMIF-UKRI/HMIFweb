<?php

namespace App\Http\Controllers;

use App\Mail\EventRegistrationMail;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PublicEventController extends Controller
{
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

    public function register(Request $request, $slug)
    {
        $event = Event::with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($event->event_mode !== 'registration') {
            return redirect()->route('event.show', $event->slug)
                ->with('error', 'Pendaftaran tidak diaktifkan untuk event ini.');
        }

        if (!in_array($event->status, ['upcoming', 'ongoing'], true)) {
            return redirect()->route('event.show', $event->slug)
                ->with('error', 'Pendaftaran event ini sudah ditutup.');
        }

        if (!$event->whatsapp_group_link) {
            return redirect()->route('event.show', $event->slug)
                ->with('error', 'Link grup WhatsApp belum disiapkan oleh panitia.');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('event_registrations')->where(fn($query) => $query->where('event_id', $event->id)),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['nullable', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar untuk event ini.',
        ]);

        $registration = $event->registrations()->create($validated);
        $emailSent = true;

        try {
            Mail::to($registration->email)->send(new EventRegistrationMail($event, $registration));
        } catch (\Throwable $exception) {
            report($exception);
            $emailSent = false;
        }

        $redirect = redirect()->route('event.show', $event->slug)
            ->with('registration_success', [
                'full_name' => $registration->full_name,
                'email' => $registration->email,
                'email_sent' => $emailSent,
            ]);

        if ($emailSent) {
            return $redirect->with('success', 'Pendaftaran berhasil. Informasi pendaftaran sudah dikirim ke email peserta.');
        }

        return $redirect->with('warning', 'Pendaftaran berhasil disimpan, tetapi email belum terkirim. Cek konfigurasi Brevo.');
    }
}
