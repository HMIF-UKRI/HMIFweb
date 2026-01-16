<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        $activePeriod = PeriodeKepengurusan::where('is_current', true)->first();

        $query = Pengurus::with(['member.media', 'department', 'bidang', 'period'])
            ->orderBy('hierarchy_level', 'asc');

        // Filter per periode
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        } else {
            $query->where('period_id', $activePeriod?->id);
        }

        $pengurus = $query->get();
        $periods = PeriodeKepengurusan::all();

        return view('admin.pengurus.index', compact('pengurus', 'periods', 'activePeriod'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'       => 'required|exists:members,id',
            'period_id'       => 'required|exists:periods,id',
            'department_id'   => 'required|exists:departments,id',
            'bidang_id'       => 'nullable|exists:bidangs,id', // Nullable untuk Kadep/Ring 1
            'hierarchy_level' => 'required|integer|in:1,2,3',
            'position'        => 'required|string|max:100',
        ]);

        Pengurus::create($validated);

        return redirect()->back()->with('success', 'Jabatan pengurus berhasil ditetapkan.');
    }

    public function update(Request $request, Pengurus $penguru)
    {
        $validated = $request->validate([
            'hierarchy_level' => 'required|integer|in:1,2,3',
            'position'        => 'required|string|max:100',
            'bidang_id'       => 'nullable|exists:bidangs,id',
        ]);

        $penguru->update($validated);

        return redirect()->back()->with('success', 'Data pengurus diperbarui.');
    }
}
