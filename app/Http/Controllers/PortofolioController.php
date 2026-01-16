<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PortofolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portofolio::with(['author', 'media']);

        // Filter berdasarkan status atau pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $portofolios = $query->latest()->paginate(10);
        return view('admin.portofolios.index', compact('portofolios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'url_github'   => 'nullable|url',
            'url_linkedin' => 'nullable|url',
            'status'       => 'required|in:Draft,Published',
            'is_featured'  => 'boolean',
            'thumbnail'    => 'required|image|max:2048',
        ]);

        // Otomatis mengambil Member ID dari user yang login
        $memberId = Auth::user()->member->id;

        // Logika Unique Slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Portofolio::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $portofolio = Portofolio::create(array_merge($validated, [
            'member_id' => $memberId,
            'slug'      => $slug,
            'is_featured' => $request->has('is_featured')
        ]));

        if ($request->hasFile('thumbnail')) {
            $portofolio->addMediaFromRequest('thumbnail')->toMediaCollection('portofolio_thumbnails');
        }

        return redirect()->route('admin.portofolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function toggleFeatured(Portofolio $portofolio)
    {
        // Fitur untuk menonjolkan karya terbaik di landing page
        $portofolio->update(['is_featured' => !$portofolio->is_featured]);
        return redirect()->back()->with('success', 'Status unggulan diperbarui.');
    }
}
