<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::all();

        $query = Blog::with(['category', 'author.media', 'media'])
            ->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->latest()->paginate(9);

        return view('page.blog.index', compact('blogs', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_blog_category' => 'required|exists:blog_categories,id',
            'title'            => 'required|string|max:255',
            'summary'          => 'nullable|string|max:255',
            'content'          => 'required|string',
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

    public function show($slug)
    {
        $blog = Blog::with(['author.media', 'category', 'media'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $blog->increment('views_count');

        $relatedBlogs = Blog::with(['media', 'category'])
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('page.blog.show', compact('blog', 'relatedBlogs'));
    }
}
