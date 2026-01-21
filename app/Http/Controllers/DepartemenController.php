<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $query = Departemen::query();

        // Fitur Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $departments = $query->withCount('members')->paginate(10);

        return view('admin.departement.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        Departemen::create($validated);

        return redirect()->back()->with('success', 'Departemen berhasil dibuat.');
    }

    public function update(Request $request, Departemen $departemen)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $departemen->id,
            'description' => 'nullable|string',
        ]);

        $departemen->update($validated);

        return redirect()->back()->with('success', 'Departemen diperbarui.');
    }

    public function destroy(Departemen $departemen)
    {
        // Cascade ditangani oleh database level onDelete('cascade')
        $departemen->delete();

        return redirect()->back()->with('success', 'Departemen dihapus.');
    }
}
