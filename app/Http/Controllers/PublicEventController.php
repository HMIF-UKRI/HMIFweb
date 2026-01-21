<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('category', 'media')->latest()->get()->map(function ($event) {
            $event->thumbnail_url = $event->getFirstMediaUrl('thumbnail', 'thumb');
            return $event;
        });

        $eventCategories = EventCategory::lazy();

        return view('page.kegiatan', compact('events', 'eventCategories'));
    }

    public function show($slug)
    {
        $event = Event::with(['category', 'media'])
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
}
