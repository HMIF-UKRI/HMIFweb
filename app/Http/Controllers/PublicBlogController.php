<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {
    }

    public function index(Request $request)
    {
        $categories = BlogCategory::all();

        $query = Blog::with(['category', 'media'])
            ->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(summary) LIKE ?', ["%{$search}%"]);
            });
        }

        $blogs = $query->latest()->paginate(6)->withQueryString();

        return view('page.blog.index', compact('blogs', 'categories'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['category', 'media'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $this->blogService->incrementViews($blog);

        $readingTime = $this->blogService->calculateReadingTime($blog->content);

        $relatedBlogs = Blog::with(['category', 'media'])
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('page.blog.show', compact('blog', 'relatedBlogs', 'readingTime'));
    }
}
