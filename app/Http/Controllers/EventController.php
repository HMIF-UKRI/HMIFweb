<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::with("eventCategory")->latest()->get();

        return view('kegiatan', compact('event'));
    }

    public function create()
    {
        $categories = EventCategory::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('event.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:event,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:250',
            'thumbnail_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'event_category_id' => 'required|exists:event_categories,id',
        ]);

        $event = new Event();
        $event->title = $validatedData['title'];
        $event->slug = $validatedData['slug'] ?: Str::slug($validatedData['title'] . '-' . time());
        $event->description = $validatedData['description'];
        $event->short_description = $validatedData['short_description'];
        $event->thumbnail_path = $validatedData['thumbnail_path'];
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_categories_id = $validatedData['event_categories_id'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event/thumbnails', $fileName, 'public');
            $event->thumbnail_path = $path;
        }

        $event->save();

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        return redirect()->route('event.edit', $event->id);
    }

    public function edit(Event $event)
    {
        $categories = EventCategory::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('event.edit', compact('event', 'categories', 'statuses'));
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:event,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:250',
            'thumbnail_path' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'event_category_id' => 'required|exists:event_categories,id',
        ]);

        $event->title = $validatedData['title'];
        $event->slug = $validatedData['slug'] ?: Str::slug($validatedData['title'] . '-' . time());
        if (empty($request->slug) && $request->title === $event->getOriginal('title')) {
            $event->slug = $event->getOriginal('slug');
        } elseif (empty($request->slug)) {
            $event->slug = Str::slug($validatedData['title'] . '-' . time());
        } else {
            $event->slug = $validatedData['slug'];
        }
        $event->description = $validatedData['description'];
        $event->short_description = $validatedData['short_description'];
        $event->thumbnail_path = $validatedData['thumbnail_path'];
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_categories_id = $validatedData['event_categories_id'];

        if ($request->hasFile('image')) {
            if ($event->thumbnail_path) {
                Storage::disk('public')->delete($event->thumbnail_path);
            }

            $file = $request->file('image');
            $fileName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event/thumbnails', $fileName, 'public');
            $event->thumbnail_path = $path;
        }

        $event->save();

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->thumbnail_path) {
            Storage::disk('public')->delete($event->thumbnail_path);
        }


        $event->delete();

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
