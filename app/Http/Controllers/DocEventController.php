<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DocumentEvents;
use Illuminate\Http\Request;

class DocEventController extends Controller
{
    public function index()
    {
        $docEvent = DocumentEvents::with('event', 'period');

        return view('admin.doc-event.index', compact('docEvent'));
    }
}
