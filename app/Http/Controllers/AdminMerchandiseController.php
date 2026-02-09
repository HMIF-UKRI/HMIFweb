<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $merchandises = Merchandise::with(['category', 'media'])->get();
        $categories = MerchandiseCategory::lazy();

        return view('admin.merchandise.index', compact('merchandises', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'merchandise_category_id' => 'required|exists:merchandise_categories,id',
            'price'                   => 'required|integer',
            'original_price'          => 'nullable|integer',
            'description'             => 'required|string',
            'stock'                   => 'nullable|integer',
            'is_new'                  => 'nullable|boolean',
            'material'                => 'nullable|string|max:255',
            'size'                    => 'nullable|string',
            'color'                   => 'nullable|string',
            'foto'                    => 'required|image|mimes:jpeg,png,jpg,webp,heic|max:5120',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $merchandise = Merchandise::create($validated);

            if ($request->hasFile('foto')) {
                $merchandise->addMediaFromRequest('foto')->toMediaCollection('merchandises');
            }

            return redirect()->back()->with('success', 'Merchandise berhasil ditambahkan.');
        });
    }

    public function update(Request $request, $id)
    {
        $merchandise = Merchandise::findOrFail($id);

        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'merchandise_category_id' => 'required|exists:merchandise_categories,id',
            'price'                   => 'required|integer',
            'original_price'          => 'nullable|integer',
            'description'             => 'required|string',
            'stock'                   => 'nullable|integer',
            'is_new'                  => 'nullable|boolean',
            'material'                => 'nullable|string|max:255',
            'size'                    => 'nullable|string',
            'color'                   => 'nullable|string',
            'foto'                    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        return DB::transaction(function () use ($request, $merchandise, $validated) {
            $merchandise->update($validated);

            if ($request->hasFile('foto')) {
                $merchandise->clearMediaCollection('merchandises');
                $merchandise->addMediaFromRequest('foto')->toMediaCollection('merchandises');
            }

            return redirect()->back()->with('success', 'Data merchandise berhasil diperbarui.');
        });
    }

    public function destroy(Merchandise $merchandise)
    {
        return DB::transaction(function () use ($merchandise) {
            $merchandise->clearMediaCollection('merchandises');
            $merchandise->delete();
            return redirect()->back()->with('success', 'Merchandise dihapus.');
        });
    }

    public function incrementStock(Merchandise $merchandise)
    {
        $merchandise->increment('stock');
        return redirect()->back()->with('success', 'Stok berhasil ditambah.');
    }

    public function decrementStock(Merchandise $merchandise)
    {
        if ($merchandise->stock > 0) {
            $merchandise->decrement('stock');
            return redirect()->back()->with('success', 'Stok berhasil dikurangi.');
        }
        return redirect()->back()->with('error', 'Stok sudah habis.');
    }
}
