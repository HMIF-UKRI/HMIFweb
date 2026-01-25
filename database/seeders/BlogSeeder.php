<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        $categoryData = ['Tutorial', 'Security', 'Web Development', 'Tech News', 'Campus Life'];
        foreach ($categoryData as $cat) {
            BlogCategory::updateOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        $categories = BlogCategory::all();
        $members = Member::all();

        if ($members->isEmpty()) {
            $this->command->warn('Tidak ada Member ditemukan. Silakan jalankan MemberSeeder terlebih dahulu atau buat member manual.');
            return;
        }

        $jsonBlogs = [
            [
                "blog_category_id" => 1,
                "title" => "Masa Depan Kecerdasan Buatan di Tahun 2026",
                "summary" => "Menjelajahi bagaimana AI akan mengubah cara mahasiswa informatika belajar dan bekerja di era transformasi digital yang semakin cepat.",
                "content" => '{"blocks":[{"type":"header","data":{"text":"Revolusi AI dalam Pendidikan","level":2}},{"type":"paragraph","data":{"text":"Pada tahun 2026, kita melihat pergeseran besar di mana AI bukan lagi sekadar alat bantu, melainkan mitra kolaborasi dalam penulisan kode dan analisis data."}},{"type":"quote","data":{"text":"Teknologi tidak menggantikan peran manusia, tetapi memperkuat potensi yang kita miliki.","caption":"Dekan Fakultas Teknik"}},{"type":"list","data":{"style":"unordered","items":["Automated code review","Personalized learning paths","Real-time data visualization"]}},{"type":"image","data":{"file":{"url":"https://images.unsplash.com/photo-1677442136019-21780ecad995"},"caption":"Visualisasi Jaringan Saraf Tiruan"}}]}',
                "views_count" => 150,
                "status" => "published"
            ],
            [
                "blog_category_id" => 2,
                "title" => "Tips Sukses Menghadapi Coding Bootcamp HMIF",
                "summary" => "Panduan lengkap bagi mahasiswa tingkat awal untuk menguasai dasar-dasar pemrograman melalui program intensif himpunan.",
                "content" => '{"blocks":[{"type":"header","data":{"text":"Persiapan Mental dan Teknis","level":2}},{"type":"paragraph","data":{"text":"Coding bootcamp menuntut fokus yang tinggi. Anda perlu memahami logika dasar sebelum terjun ke framework yang kompleks."}},{"type":"list","data":{"style":"ordered","items":["Pahami algoritma dasar","Kuasai Git version control","Bangun networking dengan senior"]}},{"type":"quote","data":{"text":"Konsistensi lebih penting daripada intensitas yang sesaat.","caption":"Ketua HMIF"}}]}',
                "views_count" => 85,
                "status" => "published"
            ],
            [
                "blog_category_id" => 3,
                "title" => "Keamanan Siber: Melindungi Data di Era Cloud",
                "summary" => "Mengapa enkripsi dan kesadaran akan privasi data menjadi mata kuliah paling relevan saat ini.",
                "content" => '{"blocks":[{"type":"header","data":{"text":"Tantangan Cloud Security","level":2}},{"type":"paragraph","data":{"text":"Dengan migrasi besar-besaran ke cloud, celah keamanan baru muncul setiap harinya. Mahasiswa informatika harus melek protokol keamanan."}},{"type":"image","data":{"file":{"url":"https://images.unsplash.com/photo-1550751827-4bd374c3f58b"},"caption":"Ilustrasi Enkripsi Data Modern"}},{"type":"paragraph","data":{"text":"Penerapan multi-factor authentication (MFA) adalah langkah awal yang paling krusial."}}]}',
                "views_count" => 42,
                "status" => "draft"
            ],
            [
                "blog_category_id" => 1,
                "title" => "Laravel 12: Fitur Baru yang Harus Kamu Coba",
                "summary" => "Ulasan mendalam mengenai rilis terbaru Laravel dan bagaimana ia mempermudah pengembangan web full-stack.",
                "content" => '{"blocks":[{"type":"header","data":{"text":"Optimalisasi Performa di Laravel 12","level":2}},{"type":"paragraph","data":{"text":"Versi terbaru ini membawa pembaruan pada engine routing dan integrasi Vite yang lebih seamless."}},{"type":"list","data":{"style":"unordered","items":["Improved database sharding","Built-in AI helper tools","Enhanced testing suite"]}},{"type":"quote","data":{"text":"The best PHP framework just got better.","caption":"Taylor Otwell"}}]}',
                "views_count" => 210,
                "status" => "published"
            ],
            [
                "blog_category_id" => 2,
                "title" => "Dokumentasi Kegiatan: Malam Keakraban Informatika",
                "summary" => "Melihat kembali keseruan acara tahunan HMIF untuk mempererat solidaritas antar angkatan.",
                "content" => '{"blocks":[{"type":"header","data":{"text":"Membangun Solidaritas Tanpa Batas","level":2}},{"type":"paragraph","data":{"text":"Acara ini dihadiri oleh lebih dari 200 mahasiswa dari berbagai angkatan di basecamp UKRI."}},{"type":"image","data":{"file":{"url":"https://images.unsplash.com/photo-1511795409834-ef04bbd61622"},"caption":"Keseruan Malam Puncak MAKRAB"}},{"type":"paragraph","data":{"text":"Terima kasih kepada seluruh panitia yang telah bekerja keras menyukseskan agenda ini."}}]}',
                "views_count" => 305,
                "status" => "published"
            ]
        ];

        foreach ($jsonBlogs as $data) {
            $category = $categories->firstWhere('id', $data['blog_category_id']) ?? $categories->random();

            $blog = Blog::create([
                'blog_category_id' => $category->id,
                'title'            => $data['title'],
                'slug'             => Str::slug($data['title']),
                'summary'          => $data['summary'],
                'content'          => $data['content'],
                'views_count'      => $data['views_count'],
                'status'           => $data['status'],
            ]);

            try {
                $blog->addMediaFromUrl('https://picsum.photos/seed/' . Str::random(10) . '/1200/800')
                    ->toMediaCollection('blog_thumbnails');
            } catch (\Exception $e) {
                $this->command->error("Gagal mendownload gambar untuk blog: " . $blog->title . " | Error: " . $e->getMessage());
            }
        }

        $this->command->info('BlogSeeder berhasil dijalankan dengan data JSON.');
    }
}
