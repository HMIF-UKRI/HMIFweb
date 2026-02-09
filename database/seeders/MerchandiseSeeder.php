<?php

namespace Database\Seeders;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchandiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryData = ['Apparel', 'accessories'];
        foreach ($categoryData as $cat) {
            MerchandiseCategory::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        $categories = MerchandiseCategory::lazy();

        $products = [
            [
                'name' => 'HMIF Premium Black Tee',
                'merchandise_category_id' => '1',
                'price' => 150000,
                'original_price' => 200000,
                'foto' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800',
                'description' => 'Kaos premium dengan material cotton combed 30s yang sangat nyaman. Desain eksklusif dengan print high-quality yang tahan lama.',
                'stock' => 35,
                'is_new' => true,
                'material' => 'Premium Cotton Combed 30s',
                'size' => 'S, M, L, XL, XXL',
                'color' => 'Deep Black'
            ],
            [
                'name' => 'Signature Hoodie',
                'merchandise_category_id' => '1',
                'price' => 350000,
                'original_price' => 450000,
                'foto' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800',
                'description' => 'Hoodie eksklusif dengan fleece premium yang super soft dan warm. Detail embroidery yang sempurna.',
                'stock' => 18,
                'is_new' => true,
                'material' => 'Premium Fleece 350gsm',
                'size' => 'M, L, XL, XXL',
                'color' => 'Midnight Black, Navy, Burgundy'
            ],
            [
                'name' => 'Exclusive Pin Set',
                'merchandise_category_id' => 2,
                'price' => 95000,
                'original_price' => null,
                'foto' => 'https://images.unsplash.com/photo-1632910121591-29e2484c0259?w=800',
                'description' => 'Set koleksi exclusive pins dengan enamel finish berkualitas tinggi.',
                'stock' => 8,
                'is_new' => true,
                'material' => 'Metal with Hard Enamel',
                'size' => 'Various (2-4cm)',
                'color' => 'Multi-color'
            ]
        ];

        foreach ($products as $data) {
            $category = $categories->firstWhere('id', $data['merchandise_category_id']) ?? $categories->random();

            $blog = Merchandise::create([
                'merchandise_category_id' => $category->id,
                'name'          => $data['name'],
                'price'         => $data['price'],
                'description'   => $data['description'],
                'stock'         => $data['stock'],
                'is_new'        => $data['is_new'],
                'material'      => $data['material'],
                'size'          => $data['size'],
                'color'         => $data['color'],
            ]);

            try {
                $blog->addMediaFromUrl($data['foto'])
                    ->toMediaCollection('merchandises');
            } catch (\Exception $e) {
                $this->command->error("Gagal mendownload gambar untuk blog: " . $blog->title . " | Error: " . $e->getMessage());
            }
        }

        $this->command->info('BlogSeeder berhasil dijalankan dengan data JSON.');
    }
}
