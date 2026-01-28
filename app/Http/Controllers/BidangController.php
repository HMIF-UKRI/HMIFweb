<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Departemen;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index(Request $request)
    {
        $departments = Departemen::lazy();
        $query = Bidang::with('department');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $bidangs = $query->paginate(10);

        return view('admin.bidang.index', compact('bidangs', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Bidang::create($validated);

        return redirect()->back()->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $bidang->update($validated);

        return redirect()->back()->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang)
    {
        $bidang->delete();

        return redirect()->back()->with('success', 'Bidang berhasil dihapus.');
    }
}
