<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\EventCategory;
use App\Models\MerchandiseCategory;
use App\Models\PortofolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CategoriesController extends Controller
{
    /** type => [tabel, panjang maksimal kolom name] */
    private const TABLES = [
        'blog' => ['blog_categories', 100],
        'event' => ['event_categories', 50],
        'porto' => ['portofolio_categories', 255],
        'merchandise' => ['merchandise_categories', 100],
    ];

    public function index()
    {
        return view('admin.categories.index', [
            'blogCategory' => BlogCategory::withCount('blogs')->latest()->get(),
            'eventCategory' => EventCategory::withCount('events')->latest()->get(),
            'portofolioCategory' => PortofolioCategory::withCount('portofolios')->latest()->get(),
            'merchandiseCategory' => MerchandiseCategory::withCount('merchandises')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $type = $this->validateType($request);
        $data = $this->validateCategory($request, $type);

        match ($type) {
            'blog' => BlogCategory::create($data),
            'event' => EventCategory::create($data),
            'porto' => PortofolioCategory::create($data),
            'merchandise' => MerchandiseCategory::create($data),
        };

        return back()->with('success', 'Kategori berhasil dibuat.');
    }

    public function update(Request $request, $slug)
    {
        $type = $this->validateType($request);

        $category = match ($type) {
            'blog'  => BlogCategory::where('slug', $slug)->firstOrFail(),
            'event' => EventCategory::where('slug', $slug)->firstOrFail(),
            'porto' => PortofolioCategory::where('slug', $slug)->firstOrFail(),
            'merchandise' => MerchandiseCategory::where('slug', $slug)->firstOrFail(),
        };

        $data = $this->validateCategory($request, $type, $category->id);

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    private function validateType(Request $request): string
    {
        return $request->validate([
            'type' => ['required', Rule::in(array_keys(self::TABLES))],
        ])['type'];
    }

    /**
     * Validasi nama sesuai batas kolom di database dan pastikan slug tidak bentrok,
     * supaya error unique/panjang data tidak lolos ke database (500).
     */
    private function validateCategory(Request $request, string $type, ?int $ignoreId = null): array
    {
        [$table, $maxName] = self::TABLES[$type];

        $validated = $request->validate([
            'name' => ['required', 'string', "max:{$maxName}"],
        ]);

        $slug = Str::slug($validated['name']);

        if ($slug === '') {
            throw ValidationException::withMessages([
                'name' => 'Nama kategori harus mengandung huruf atau angka.',
            ]);
        }

        $exists = DB::table($table)
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'name' => "Kategori '{$validated['name']}' sudah ada.",
            ]);
        }

        return [
            'name' => $validated['name'],
            'slug' => $slug,
        ];
    }

    public function destroy(Request $request, $slug)
    {
        $type = $request->type;

        $model = match ($type) {
            'blog' => BlogCategory::where('slug', $slug)->firstOrFail(),
            'event' => EventCategory::where('slug', $slug)->firstOrFail(),
            'porto' => PortofolioCategory::where('slug', $slug)->firstOrFail(),
            'merchandise' => MerchandiseCategory::where('slug', $slug)->firstOrFail(),
            default => abort(404)
        };

        $hasRelation = match ($type) {
            'blog' => $model->blogs()->exists(),
            'event' => $model->events()->exists(),
            'porto' => $model->portofolios()->exists(),
            'merchandise' => $model->merchandises()->exists(),
        };

        if ($hasRelation) {
            return back()->with('error', "Kategori '{$model->name}' tidak bisa dihapus karena masih memiliki data terkait.");
        }

        $model->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
