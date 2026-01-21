<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\EventCategory;
use App\Models\PortofolioCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $blogCategory = BlogCategory::lazy();
        $eventCategory = EventCategory::lazy();
        $portofolioCategory = PortofolioCategory::lazy();

        return view('admin.categories.index', compact('blogCategory', 'eventCategory', 'portofolioCategory'));
    }
}
