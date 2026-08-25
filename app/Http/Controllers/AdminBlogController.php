<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Requests\Blog\UploadBlogImageRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {
    }

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

        $blogs = $query->latest()->paginate(9)->withQueryString();
        $categories = BlogCategory::all();

        return view('admin.blog.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::all();

        return view('admin.blog.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request)
    {
        $this->blogService->createBlog(
            data: $request->validated(),
            thumbnail: $request->file('thumbnail')
        );

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog berhasil diterbitkan.');
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->with(['category', 'media'])
            ->firstOrFail();

        return view('admin.blog.show', compact('blog'));
    }

    public function edit($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $categories = BlogCategory::all();

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(UpdateBlogRequest $request, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $this->blogService->updateBlog(
            blog: $blog,
            data: $request->validated(),
            thumbnail: $request->file('thumbnail')
        );

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Data blog berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $this->blogService->deleteBlog($blog);

        return redirect()
            ->back()
            ->with('success', 'Blog berhasil dihapus.');
    }

    public function uploadImage(UploadBlogImageRequest $request)
    {
        try {
            $result = $this->blogService->uploadEditorImage($request->file('image'));

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
