<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicPortofolioController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function toggleFeatured(Portofolio $portofolio)
    {
        //
    }
}
