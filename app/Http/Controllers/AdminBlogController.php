<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'author.media', 'media'])
            ->where('status', 'published');

        return view('admin.blog.index', compact('blogs'));
    }
}
