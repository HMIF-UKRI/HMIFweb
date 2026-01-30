<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\EventCategory;
use App\Models\PortofolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'blogCategory' => BlogCategory::withCount('blogs')->latest()->get(),
            'eventCategory' => EventCategory::withCount('events')->latest()->get(),
            'portofolioCategory' => PortofolioCategory::withCount('portofolios')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $type = $request->type;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ];

        match ($type) {
            'blog' => BlogCategory::create($data),
            'event' => EventCategory::create($data),
            'porto' => PortofolioCategory::create($data),
        };

        return back()->with('success', 'Kategori berhasil dibuat.');
    }

    public function update(Request $request, $slug)
    {
        $type = $request->type;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = match ($type) {
            'blog'  => BlogCategory::where('slug', $slug)->firstOrFail(),
            'event' => EventCategory::where('slug', $slug)->firstOrFail(),
            'porto' => PortofolioCategory::where('slug', $slug)->firstOrFail(),
            default => abort(404),
        };

        $data = [
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ];

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, $slug)
    {
        $type = $request->type;

        $model = match ($type) {
            'blog' => BlogCategory::where('slug', $slug)->firstOrFail(),
            'event' => EventCategory::where('slug', $slug)->firstOrFail(),
            'porto' => PortofolioCategory::where('slug', $slug)->firstOrFail(),
            default => abort(404)
        };

        $hasRelation = match ($type) {
            'blog' => $model->blogs()->exists(),
            'event' => $model->events()->exists(),
            'porto' => $model->portofolios()->exists(),
        };

        if ($hasRelation) {
            return back()->with('error', "Kategori '{$model->name}' tidak bisa dihapus karena masih memiliki data terkait.");
        }

        $model->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
