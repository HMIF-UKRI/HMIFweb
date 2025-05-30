<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('EventCategories')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('event_category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10)->withQueryString();
        $categories = EventCategories::orderBy('name')->get();

        return view('kegiatan', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = EventCategories::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('admin.events.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:events,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:250',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'event_category_id' => 'required|exists:event_categories,id',
        ]);

        $event = new Event();
        $event->title = $validatedData['title'];
        $event->slug = $validatedData['slug'] ?: Str::slug($validatedData['title'] . '-' . time());
        $event->description = $validatedData['description'];
        $event->short_description = $validatedData['short_description'];
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_category_id = $validatedData['event_category_id'];

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('events/thumbnails', $fileName, 'public');
            $event->thumbnail_path = $path;
        }

        $event->save();

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event->id);
    }

    public function edit(Event $event)
    {
        $categories = EventCategories::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('admin.events.edit', compact('event', 'categories', 'statuses'));
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:events,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:250',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
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
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_category_id = $validatedData['event_category_id'];

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail_path) {
                Storage::disk('public')->delete($event->thumbnail_path);
            }

            $file = $request->file('thumbnail');
            $fileName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('events/thumbnails', $fileName, 'public');
            $event->thumbnail_path = $path;
        }

        $event->save();

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->thumbnail_path) {
            Storage::disk('public')->delete($event->thumbnail_path);
        }


        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
