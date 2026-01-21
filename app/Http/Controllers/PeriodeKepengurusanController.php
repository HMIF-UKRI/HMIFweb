<?php

namespace App\Http\Controllers;

use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodeKepengurusanController extends Controller
{
    public function index()
    {
        $periods = PeriodeKepengurusan::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.periode.index', compact('periods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabinet_name' => 'required|string|max:100',
            'period_range' => 'required|string',
            'vision'       => 'nullable|string',
            'mission'      => 'nullable|string',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
            'is_current'   => 'boolean',
            'logo'         => 'nullable|image|max:2048'
        ]);

        DB::transaction(function () use ($validated, $request) {
            if ($request->has('is_current') && $request->is_current) {
                PeriodeKepengurusan::where('is_current', true)->update(['is_current' => false]);
            }

            $periode = PeriodeKepengurusan::create($validated);

            if ($request->hasFile('logo')) {
                $periode->addMediaFromRequest('logo')->toMediaCollection('cabinet_logos');
            }
        });

        return redirect()->back()->with('success', 'Periode baru berhasil disinkronisasi.');
    }

    public function update(Request $request, PeriodeKepengurusan $periode)
    {
        $validated = $request->validate([
            'cabinet_name' => 'required|string|max:100',
            'period_range' => 'required|string',
            'vision'       => 'nullable|string',
            'mission'      => 'nullable|string',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
            'is_current'   => 'boolean',
            'logo'         => 'nullable|image|max:2048'
        ]);

        DB::transaction(function () use ($validated, $request, $periode) {
            if ($request->has('is_current') && $request->is_current) {
                PeriodeKepengurusan::where('id', '!=', $periode->id)
                    ->where('is_current', true)
                    ->update(['is_current' => false]);
            }

            $periode->update($validated);

            if ($request->hasFile('logo')) {
                $periode->clearMediaCollection('cabinet_logos');
                $periode->addMediaFromRequest('logo')->toMediaCollection('cabinet_logos');
            }
        });

        return redirect()->back()->with('success', 'Data periode berhasil diperbarui.');
    }

    public function destroy(PeriodeKepengurusan $periode)
    {
        // Hindari menghapus periode yang sedang aktif
        if ($periode->is_current) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus periode yang sedang aktif.');
        }

        $periode->delete();
        return redirect()->back()->with('success', 'Periode berhasil dihapus.');
    }
}
