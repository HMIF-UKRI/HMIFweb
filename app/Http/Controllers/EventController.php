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
        $events = Event::with("eventCategory")->latest()->get();

        return view('page.event.index', compact('events'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $relatedEvents = Event::where('id', '!=', $event->id)
            ->inRandomOrder()
            ->limit(3)
            ->with('eventCategory')
            ->get();

        return view('page.event.show', compact('event', 'relatedEvents'));
    }

    public function create()
    {
        $events = Event::with("eventCategory")->latest()->get();
        $eventCategories = EventCategory::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('page.event.create', compact('events', 'eventCategories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'string|max:255|unique:events,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:250',
            'thumbnail_path' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:berlangsung,rutin,selesai,dibatalkan',
            'event_category_id' => 'required',
        ]);

        $event = new Event();
        $event->title = $validatedData['title'];
        $event->slug = Str::slug($validatedData['title'] . '-' . time());
        $event->description = $validatedData['description'];
        $event->short_description = $validatedData['short_description'];
        $event->thumbnail_path = $validatedData['thumbnail_path'];
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_category_id = $validatedData['event_category_id'];

        if ($request->hasFile('thumbnail_path')) {
            $file = $request->file('thumbnail_path');
            $fileName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('event/thumbnails', $fileName, 'public');
            $event->thumbnail_path = $path;
        }

        $event->save();

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        if (!$event) {
            return redirect()->route('event.index')->with('error', 'Kegiatan tidak ditemukan.');
        }
        $eventCategories = EventCategory::orderBy('name')->get();
        $statuses = ['upcoming' => 'Upcoming', 'routine' => 'Routine', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
        return view('page.event.edit', compact('event', 'eventCategories', 'statuses'));
    }

    public function update(Request $request, Event $event)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                // 'slug' => 'string|max:255|unique:events,slug',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:250',
                'thumbnail_path' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'event_date' => 'required|date',
                'location' => 'required|string|max:255',
                'status' => 'required|in:berlangsung,rutin,selesai,dibatalkan',
                'event_category_id' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        $event->title = $validatedData['title'];
        if ($request->title !== $event->getOriginal('title')) {
            $event->slug = Str::slug($validatedData['title'], '-');
            // Pastikan slug unik jika diubah
            $count = 2;
            $originalSlug = $event->slug;
            while (Event::where('slug', $event->slug)->where('id', '!=', $event->id)->exists()) {
                $event->slug = "{$originalSlug}-{$count}";
                $count++;
            }
        }
        $event->description = $validatedData['description'];
        $event->short_description = $validatedData['short_description'];
        $event->event_date = $validatedData['event_date'];
        $event->location = $validatedData['location'];
        $event->status = $validatedData['status'];
        $event->event_category_id = $validatedData['event_category_id'];

        // Handle file upload untuk thumbnail jika ada file baru
        if ($request->hasFile('thumbnail_path')) {
            try {
                $imageName = 'event_thumbnail_' . time() . '_' . Str::slug($validatedData['title']) . '.' . $request->thumbnail_path->extension();
                $path = $request->thumbnail_path->storeAs('event/thumbnails', $imageName, 'public');
                $event->thumbnail_path = $path;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Gagal mengunggah file: ' . $e->getMessage())
                    ->withInput();
            }
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
