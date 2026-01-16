<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;

class PeriodeKepengurusanController extends Controller
{
    public function index()
    {
        $periods = PeriodeKepengurusan::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabinet_name' => 'required|string|max:255',
            'period_range' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'cabinet_logo' => 'required|image|max:2048',
            'is_current' => 'boolean',
        ]);

        if ($request->is_current) {
            PeriodeKepengurusan::where('is_current', true)->update(['is_current' => false]);
        }

        $period = PeriodeKepengurusan::create($validated);

        if ($request->hasFile('cabinet_logo')) {
            $period->addMediaFromRequest('cabinet_logo')->toMediaCollection('cabinet_logos');
        }

        return redirect()->back()->with('success', 'Periode kabinet berhasil disimpan.');
    }
}
