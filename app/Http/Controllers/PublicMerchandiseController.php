<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\MerchandiseCategory;

class PublicMerchandiseController extends Controller
{
    public function index()
    {
        $merchandises = Merchandise::with(['category', 'media'])->get();
        $categories = MerchandiseCategory::lazy();

        return view('page.merchandise', compact('merchandises', 'categories'));
    }
}
