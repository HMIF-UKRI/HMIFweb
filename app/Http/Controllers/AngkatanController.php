<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    public function index()
    {
        $generations = Angkatan::withCount('members')->orderBy('year', 'desc')->get();
        return view('admin.generations.index', compact('generations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|numeric|unique:generations,year',
            'description' => 'nullable|string|max:255',
        ]);

        Angkatan::create($validated);

        return redirect()->back()->with('success', 'Angkatan berhasil ditambahkan.');
    }

    public function update(Request $request, Angkatan $generation)
    {
        $validated = $request->validate([
            'year' => 'required|numeric|unique:generations,year,' . $generation->id,
            'description' => 'nullable|string|max:255',
        ]);

        $generation->update($validated);

        return redirect()->back()->with('success', 'Data angkatan diperbarui.');
    }

    public function destroy(Angkatan $generation)
    {
        if ($generation->members()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus angkatan yang masih memiliki anggota.');
        }

        $generation->delete();
        return redirect()->back()->with('success', 'Angkatan berhasil dihapus.');
    }
}
