<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('category', 'media');

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(summary) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('blog_category_id', $request->category_id);
        }

        $blogs = $query->latest()->paginate(9);
        $categories = BlogCategory::all();

        return view('admin.blog.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id'  => 'required|exists:blog_categories,id',
            'title'             => 'required|string|max:255',
            'summary'           => 'required|string|max:255',
            'content'           => 'required|string',
            'status'            => 'required|in:draft,published,archived',
            'thumbnail'         => 'required|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title']);

            $blog = Blog::create($validated);

            if ($request->hasFile('thumbnail')) {
                $blog->addMediaFromRequest('thumbnail')->toMediaCollection('blog_thumbnails');
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Blog berhasil diluncurkan.');
        });
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->with(['category', 'media'])->firstOrFail();
        return view('admin.blog.show', compact('blog'));
    }

    public function edit($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'blog_category_id'  => 'required|exists:blog_categories,id',
            'title'             => 'required|string|max:255',
            'summary'           => 'required|string|max:255',
            'content'           => 'required|string',
            'status'            => 'required|in:draft,published,archived',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
        ]);

        return DB::transaction(function () use ($request, $blog, $validated) {
            if ($request->title !== $blog->title) {
                $blog->slug = $this->generateUniqueSlug($validated['title'], $blog->id);
            }

            $blog->update($validated);

            if ($request->hasFile('thumbnail')) {
                $blog->clearMediaCollection('blog_thumbnails');
                $blog->addMediaFromRequest('thumbnail')->toMediaCollection('blog_thumbnails');
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Data blog berhasil diperbarui.');
        });
    }

    private function generateUniqueSlug($title, $exceptId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Blog::where('slug', $slug)->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return DB::transaction(function () use ($blog) {
            $blog->clearMediaCollection('blog_thumbnails');
            $blog->delete();
            return redirect()->back()->with('success', 'Blog dihapus.');
        });
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,webp,heic|max:5120']);
            $path = $request->file('image')->store('editor-uploads/blog', 'public');
            return response()->json(['success' => 1, 'file' => ['url' => asset('storage/' . $path)]], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => $e->getMessage()], 500);
        }
    }
}
