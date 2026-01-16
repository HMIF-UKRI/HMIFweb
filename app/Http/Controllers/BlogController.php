<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author', 'media']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_blog_category' => 'required|exists:blog_categories,id',
            'title'            => 'required|string|max:255',
            'summary'          => 'nullable|string|max:255',
            'content'          => 'required|string', // Pastikan kolom ini ada di migrasi/model Anda
            'status'           => 'required|in:Draft,Published',
            'thumbnail'        => 'required|image|max:2048',
        ]);

        // Mengambil member_id dari user login
        $memberId = Auth::user()->member->id;

        // Generate Unique Slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $blog = Blog::create(array_merge($validated, [
            'member_id' => $memberId,
            'slug'      => $slug
        ]));

        if ($request->hasFile('thumbnail')) {
            $blog->addMediaFromRequest('thumbnail')->toMediaCollection('blog_thumbnails');
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Artikel berhasil diterbitkan.');
    }
}
