<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Departemen;
use App\Models\Member;
use App\Models\Pengurus;
use App\Models\PeriodeKepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PengurusController extends Controller
{
    public function index()
    {
        $query = Pengurus::with(['member.generation', 'member.media', 'period', 'department', 'bidang']);

        if (request()->filled('period_id')) {
            $query->where('period_id', request()->period_id);
        }

        $pengurus = $query->orderBy('hierarchy_level', 'asc')->paginate(12);

        return view('admin.pengurus.index', [
            'pengurus' => $pengurus,
            'members' => Member::orderBy('full_name')->get(),
            'periods' => PeriodeKepengurusan::orderBy('start_date', 'desc')->get(),
            'departments' => Departemen::all(),
            'bidangs' => Bidang::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'       => 'required|exists:members,id',
            'period_id'       => 'required|exists:periods,id',
            'department_id'   => 'required|exists:departments,id',
            'bidang_id'       => 'nullable|exists:bidangs,id',
            'hierarchy_level' => 'required|integer|min:1|max:10',
            'position'        => 'required|string|max:100',
            'card'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = Arr::except($validated, ['card']);

        $pengurus = Pengurus::create($data);

        if ($request->hasFile('card')) {
            $pengurus->addMediaFromRequest('card')
                ->toMediaCollection('foto_pengurus');
        }

        return redirect()->route('admin.managements.index')->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, Pengurus $management)
    {
        $validated = $request->validate([
            'member_id'       => 'required|integer|exists:members,id',
            'period_id'       => 'required|integer|exists:periods,id',
            'department_id'   => 'required|integer|exists:departments,id',
            'bidang_id'       => 'nullable|integer|exists:bidangs,id',
            'hierarchy_level' => 'required|integer|min:1|max:10',
            'position'        => 'required|string|max:100',
            'card'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (!$validated) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = Arr::except($validated, ['card']);

        $management->update($data);

        if ($request->hasFile('card')) {
            $management->clearMediaCollection('foto_pengurus');
            $management->addMediaFromRequest('card')
                ->toMediaCollection('foto_pengurus');
        }

        return redirect()->route('admin.managements.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();
        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}
