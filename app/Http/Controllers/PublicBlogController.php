<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
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

    public function show($slug)
    {
        $blog = Blog::with(['category', 'author.media', 'media'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedBlogs = Blog::with(['category', 'author.media', 'media'])
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('page.blog.show', compact('blog', 'relatedBlogs'));
    }
}
