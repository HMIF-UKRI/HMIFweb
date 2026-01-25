<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'period_id'         => 'required|exists:periods,id',
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'required|date',
            'location'          => 'required|string|max:255',
            'status'            => 'required|in:upcoming,ongoing,completed,cancelled',
            'thumbnail'         => 'required|image|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $member = Auth::user()->member;
            if (!$member) {
                return redirect()->back()->with('error', 'Akaun anda tidak mempunyai profil Ahli.');
            }

            $validated['member_id'] = $member->id;
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);

            $event = Event::create($validated);

            if ($request->hasFile('thumbnail')) {
                $event->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
            }

            return redirect()->route('admin.events.index')->with('success', 'Event berjaya diterbitkan.');
        });
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->with(['category', 'period', 'media'])->firstOrFail();
        return view('admin.event.show', compact('event'));
    }

    public function edit($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $categories = EventCategory::all();
        $periods = PeriodeKepengurusan::all();
        return view('admin.event.edit', compact('event', 'categories', 'periods'));
    }

    public function update(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'period_id'         => 'required|exists:periods,id',
            'title'             => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description'       => 'required|string',
            'event_date'        => 'required|date',
            'location'          => 'required|string|max:255',
            'status'            => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        return DB::transaction(function () use ($request, $event, $validated) {
            if ($request->title !== $event->title) {
                $validated['slug'] = $this->generateUniqueSlug($request->title, $event->id);
            }

            $event->update($validated);

            if ($request->hasFile('thumbnail')) {
                $event->clearMediaCollection('thumbnails');
                $event->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
            }

            return redirect()->route('admin.events.index')->with('success', 'Data event berjaya dikemaskini.');
        });
    }

    public function destroy($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return DB::transaction(function () use ($event) {
            $event->clearMediaCollection('thumbnails');
            $event->delete();
            return redirect()->back()->with('success', 'Event dihapus.');
        });
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:2048',
            ]);

            $path = $request->file('image')->store('editor-uploads', 'public');

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset('storage/' . $path),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function generateUniqueSlug($title, $exceptId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        while (Event::where('slug', $slug)->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        return $slug;
    }
}
