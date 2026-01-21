<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category', 'media');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('event_category_id', $request->category_id);
        }

        $events = $query->latest()->paginate(9);
        $categories = EventCategory::lazy();

        return view('admin.event.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('admin.event.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'required|date',
            'location'          => 'required|string|max:255',
            'status'            => 'required|in:upcoming,ongoing,completed,cancelled',
            'thumbnail'         => 'required|image|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Event::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;

            $event = Event::create($validated);

            if ($request->hasFile('thumbnail')) {
                $event->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
            }

            return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat.');
        });
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'required|date',
            'location'          => 'required|string|max:255',
            'status'            => 'required|in:upcoming,ongoing,completed,cancelled',
            'thumbnail'         => 'nullable|image|max:2048',
        ]);

        if ($request->title !== $event->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $event->slug = $slug;
        }

        $event->update($validated);

        if ($request->hasFile('thumbnail')) {
            $event->syncAssets('thumbnail', 'thumbnails');
            $event->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
        }

        return redirect()->route('admin.events.index')->with('success', 'Event diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Event dihapus.');
    }
}
