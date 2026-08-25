<?php

namespace Database\Seeders;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchandiseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = MerchandiseCategory::all()->keyBy('name');

        $products = [
            [
                'name'            => 'HMIF Official T-Shirt MetaForsa Edition',
                'category'        => 'Apparel',
                'price'           => 120000,
                'original_price'  => 145000,
                'image_url'       => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800',
                'description'     => 'Kaos resmi HMIF UKRI edisi kepengurusan MetaForsa. Menggunakan bahan Premium Cotton Combed 24s dengan jahitan rantai rapi dan sablon Plastisol High-Density yang awet dan adem digunakan seharian.',
                'stock'           => 45,
                'is_new'          => true,
                'material'        => 'Premium Cotton Combed 24s Heavyweight',
                'size'            => 'S, M, L, XL, XXL, 3XL',
                'color'           => 'Jet Black, Solid White'
            ],
            [
                'name'            => 'Signature HMIF UKRI Zip Hoodie',
                'category'        => 'Apparel',
                'price'           => 265000,
                'original_price'  => 310000,
                'image_url'       => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800',
                'description'     => 'Hoodie beritsleting eksklusif dengan material Cotton Fleece tebal dan lembut di kulit. Dilengkapi bordir presisi lambang HMIF di dada kiri dan patch MetaForsa di lengan kanan.',
                'stock'           => 25,
                'is_new'          => true,
                'material'        => 'Heavyweight Cotton Fleece 330gsm',
                'size'            => 'M, L, XL, XXL',
                'color'           => 'Midnight Navy, Dark Charcoal'
            ],
            [
                'name'            => 'HMIF Exclusive Lanyard & Card Holder Set',
                'category'        => 'Accessories',
                'price'           => 45000,
                'original_price'  => null,
                'image_url'       => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?w=800',
                'description'     => 'Set tali lanyard tenun jacquard berkualitas tinggi lengkap dengan case ID Card matte anti gores. Cocok untuk kartu tanda mahasiswa (KTM) atau kartu akses RFID.',
                'stock'           => 60,
                'is_new'          => false,
                'material'        => 'Woven Jacquard Strap + Matte Hardcase ID',
                'size'            => 'Standard (90cm x 2cm)',
                'color'           => 'Navy Blue & White Accent'
            ],
            [
                'name'            => 'Hard Enamel Pin HMIF UKRI Shield',
                'category'        => 'Accessories',
                'price'           => 35000,
                'original_price'  => null,
                'image_url'       => 'https://images.unsplash.com/photo-1632910121591-29e2484c0259?w=800',
                'description'     => 'Pin enamel premium bertekstur glossy dengan plating emas elegan. Sangat pas disematkan di jaket, totebag, lanyard, atau topi almamater.',
                'stock'           => 40,
                'is_new'          => false,
                'material'        => 'Zinc Alloy with Gold Plated Enamel',
                'size'            => '3.5 cm x 3 cm',
                'color'           => 'Gold & Navy Enamel'
            ],
            [
                'name'            => 'Developer & Cyber Sticker Pack (12 pcs)',
                'category'        => 'Stationery & Stickers',
                'price'           => 25000,
                'original_price'  => 35000,
                'image_url'       => 'https://images.unsplash.com/photo-1589384267710-7a25bf6a0662?w=800',
                'description'     => 'Paket 12 stiker vinyl die-cut bertema coding, cybersecurity, meme programmer, dan logo HMIF UKRI. Tahan air (waterproof), anti luntur, dan tidak meninggalkan bekas lem di laptop.',
                'stock'           => 80,
                'is_new'          => true,
                'material'        => 'Vinyl Matte Laminated Waterproof (Die-cut)',
                'size'            => 'Various (5-8cm)',
                'color'           => 'Full Color Aesthetic'
            ],
            [
                'name'            => 'HMIF Heavy Canvas Totebag with Zipper',
                'category'        => 'Accessories',
                'price'           => 75000,
                'original_price'  => 90000,
                'image_url'       => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=800',
                'description'     => 'Tas jinjing kanvas tebal dengan resleting penutup utama dan kompartemen dalam untuk laptop 14 inch. Kuat membawa buku kuliah dan perlengkapan harian.',
                'stock'           => 30,
                'is_new'          => true,
                'material'        => 'Premium Unbleached Canvas 14oz + YKK Zipper',
                'size'            => '38cm x 42cm x 8cm',
                'color'           => 'Natural Off-White & Black'
            ],
        ];

        foreach ($products as $data) {
            $category = $categories->get($data['category']) ?? MerchandiseCategory::firstOrCreate(
                ['slug' => Str::slug($data['category'])],
                ['name' => $data['category']]
            );

            $merchandise = Merchandise::updateOrCreate(
                ['name' => $data['name']],
                [
                    'merchandise_category_id' => $category->id,
                    'price'                   => $data['price'],
                    'original_price'          => $data['original_price'],
                    'description'             => $data['description'],
                    'stock'                   => $data['stock'],
                    'is_new'                  => $data['is_new'],
                    'material'                => $data['material'],
                    'size'                    => $data['size'],
                    'color'                   => $data['color'],
                ]
            );

            if (!$merchandise->hasMedia('merchandises')) {
                try {
                    $merchandise->addMediaFromUrl($data['image_url'])
                        ->toMediaCollection('merchandises');
                } catch (\Throwable $e) {
                    $fallback = database_path('seeders/images/dummy.png');
                    if (file_exists($fallback)) {
                        $merchandise->addMedia($fallback)
                            ->preservingOriginal()
                            ->toMediaCollection('merchandises');
                    }
                }
            }
        }

        $this->command->info('6 Merchandise semi-real resmi HMIF UKRI berhasil dibuat!');
    }
}

