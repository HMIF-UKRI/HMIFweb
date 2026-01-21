<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function index()
    {
        $galleries = Gallery::lazy();

        return view('admin.gallery.index', compact('galleries'));
    }
}
