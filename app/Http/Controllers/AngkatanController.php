<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    public function index()
    {
        $generations = Angkatan::withCount('members')
            ->orderBy('year', 'desc')
            ->paginate(10);

        return view('admin.angkatan.index', compact('generations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|numeric|digits:4|unique:generations,year',
            'description' => 'nullable|string|max:100',
        ]);

        Angkatan::create($validated);
        return redirect()->back()->with('success', "Angkatan {$request->year} berhasil diarsipkan.");
    }

    public function update(Request $request, $id)
    {
        $angkatan = Angkatan::findOrFail($id);

        $validated = $request->validate([
            'year' => 'required|numeric|digits:4|unique:generations,year,' . $angkatan->id,
            'description' => 'nullable|string|max:100',
        ]);

        try {
            $angkatan->update($validated);
            return redirect()->back()->with('success', "Data Angkatan {$angkatan->year} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Gagal memperbarui data. Silakan coba lagi.");
        }
    }

    public function destroy($id)
    {
        $angkatan = Angkatan::findOrFail($id);

        if ($angkatan->members()->exists()) {
            return redirect()->back()->with('error', "Gagal! Angkatan {$angkatan->year} masih memiliki anggota aktif.");
        }

        $angkatan->delete();
        return redirect()->back()->with('success', 'Data angkatan telah dihapus dari sistem.');
    }
}
