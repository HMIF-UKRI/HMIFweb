<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = BlogCategory::all()->keyBy('name');

        $blogsData = [
            [
                'category'    => 'Artificial Intelligence',
                'title'       => 'Masa Depan Kecerdasan Buatan & Software Engineering di Tahun 2026',
                'summary'     => 'Menjelajahi bagaimana AI agents dan multimodal LLM mentransformasi cara developer membangun perangkat lunak serta adaptasi mahasiswa informatika.',
                'status'      => 'published',
                'views_count' => 450,
                'image_url'   => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Evolusi AI dalam Dunia Rekayasa Perangkat Lunak', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Memasuki tahun 2026, AI bukan lagi sekadar pelengkap atau autocomplete kode sederhana. Pergeseran paradigma kini mengarah ke autonomous coding agents yang mampu merancang arsitektur, merefaktor codebase besar, hingga menguji sistem secara komprehensif.']],
                    ['type' => 'header', 'data' => ['text' => 'Keterampilan Kunci Mahasiswa Informatika', 'level' => 3]],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'System Architecture & Domain Knowledge: Memahami konteks bisnis dan perancangan sistem menyeluruh.',
                        'AI-Assisted Pair Programming: Efektivitas berkomunikasi dan mengarahkan AI untuk memecahkan masalah kompleks.',
                        'Cybersecurity & Ethical AI: Memastikan kode yang dihasilkan aman dari celah kerentanan dan mematuhi privasi data.'
                    ]]],
                    ['type' => 'quote', 'data' => ['text' => 'Teknologi tidak menggantikan programmer yang berpikir kritis, tetapi programmer yang memanfaatkan AI akan melangkah jauh lebih cepat.', 'caption' => 'Riset & Teknologi HMIF UKRI']]
                ]])
            ],
            [
                'category'    => 'Web Development',
                'title'       => 'Roadmap Full-Stack Web Developer Modern: Dari Fundamental hingga Cloud Native',
                'summary'     => 'Panduan terstruktur langkah demi langkah bagi mahasiswa untuk menguasai stack web development yang paling diminati industri.',
                'status'      => 'published',
                'views_count' => 380,
                'image_url'   => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Pondasi Utama Full-Stack Engineering', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Banyak pemula terjebak dalam tutorial hell karena melompati konsep dasar. Sebelum menyentuh framework modern, pastikan Anda menguasai fundamental web: HTTP/HTTPS protokol, JavaScript ES6+, DOM manipulation, dan relasi database SQL.']],
                    ['type' => 'header', 'data' => ['text' => 'Tahapan Roadmap', 'level' => 3]],
                    ['type' => 'list', 'data' => ['style' => 'ordered', 'items' => [
                        'Fase 1: HTML Semantic, Responsive CSS Modern (Flexbox, Grid, Tailwind CSS), dan Vanilla JavaScript',
                        'Fase 2: Backend Framework (Laravel 12 / Node.js Express), RESTful API, dan Relational DB (MySQL / PostgreSQL)',
                        'Fase 3: Modern Frontend Framework (Vue 3 / React) dengan State Management & SPA Routing',
                        'Fase 4: Docker Containerization, CI/CD GitHub Actions, dan Deployment ke Cloud Provider (VPS / AWS)'
                    ]]]
                ]])
            ],
            [
                'category'    => 'Cyber Security',
                'title'       => 'Panduan Praktis Keamanan Siber: Mengamankan REST API & Pencegahan Serangan Web',
                'summary'     => 'Mengenal teknik mitigasi kerentanan OWASP Top 10 pada aplikasi web modern dan tips audit keamanan dasar.',
                'status'      => 'published',
                'views_count' => 290,
                'image_url'   => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Mengapa Keamanan API Sangat Krusial?', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Sebagian besar celah kebocoran data di aplikasi modern berakar pada kesalahan konfigurasi endpoint API. Mulai dari Broken Object Level Authorization (BOLA) hingga kebocoran token otentikasi.']],
                    ['type' => 'header', 'data' => ['text' => 'Langkah Pengamanan Esensial', 'level' => 3]],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'Terapkan Rate Limiting dan Throttling untuk menangkal serangan Brute Force.',
                        'Validasi dan sanitasi seluruh input request secara ketat di sisi server.',
                        'Gunakan token otentikasi dengan masa berlaku singkat dan enkripsi HTTPS/TLS 1.3.',
                        'Terapkan principle of least privilege pada hak akses database dan API keys.'
                    ]]]
                ]])
            ],
            [
                'category'    => 'Tutorial',
                'title'       => 'Mengenal Laravel 12: Fitur Baru, Optimasi Performa, dan Best Practices',
                'summary'     => 'Bedah fitur terbaru framework PHP terpopuler di dunia dan cara memanfaatkannya untuk efisiensi koding tim pengembang.',
                'status'      => 'published',
                'views_count' => 520,
                'image_url'   => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Pembaruan Signifikan di Laravel 12', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Laravel 12 menghadirkan peningkatan engine routing yang lebih hemat memori, struktur konfigurasi yang semakin ramping, serta dukungan penuh untuk fitur-fitur modern PHP 8.3+.']],
                    ['type' => 'quote', 'data' => ['text' => 'Ekosistem Laravel terus membuktikan bahwa pengembangan web berbasis PHP dapat terasa sangat modern, elegan, dan berkinerja tinggi.', 'caption' => 'Divisi Software Dev HMIF UKRI']]
                ]])
            ],
            [
                'category'    => 'Tech News',
                'title'       => 'Membangun Portofolio Tech yang Dilirik Recruiter: Tips Mahasiswa Informatika',
                'summary'     => 'Bagaimana cara menyusun showcase proyek, profil GitHub, dan CV teknis agar menarik perhatian perusahaan teknologi impian.',
                'status'      => 'published',
                'views_count' => 310,
                'image_url'   => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Fokus pada Kualitas dan Dampak Proyek', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Satu proyek kompleks dengan testing, arsitektur rapi, dokumentasi README yang jelas, dan live demo yang dapat diuji jauh lebih bernilai di mata recruiter dibanding puluhan proyek kloning tutorial yang belum selesai.']]
                ]])
            ],
            [
                'category'    => 'Campus Life',
                'title'       => 'Dokumentasi & Keseruan Malam Keakraban (MAKRAB) Informatika UKRI 2025',
                'summary'     => 'Melihat kembali momen hangat kebersamaan dan pengakraban seluruh mahasiswa informatika di Villa Istana Bunga Lembang.',
                'status'      => 'published',
                'views_count' => 640,
                'image_url'   => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Membangun Solidaritas Tanpa Sekat', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Kegiatan MAKRAB 2025 sukses mempertemukan ratusan mahasiswa aktif dan alumni lintas angkatan. Terima kasih kepada seluruh panitia dan partisipan yang telah menyukseskan acara ini!']]
                ]])
            ],
            [
                'category'    => 'Tutorial',
                'title'       => 'Eksplorasi UI/UX Design System: Membangun Antarmuka Web yang Estetik dan Aksesibel',
                'summary'     => 'Prinsip desain antarmuka modern, typography scale, color tokens, dan perancangan komponen UI yang ramah pengguna.',
                'status'      => 'published',
                'views_count' => 210,
                'image_url'   => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Pentingnya Konsistensi Desain', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Design system bukan hanya tentang keindahan visual, tetapi juga efisiensi kolaborasi antara desainer UI/UX dan frontend developer melalui komponen yang reusable dan terdokumentasi rapi.']]
                ]])
            ],
            [
                'category'    => 'Campus Life',
                'title'       => 'Pengalaman Magang & Studi Independen Bersertifikat (MSIB) di Tech Unicorn',
                'summary'     => 'Kisah inspiratif mahasiswa Informatika UKRI yang berhasil menembus seleksi ketat program magang nasional dan tips persiapannya.',
                'status'      => 'draft',
                'views_count' => 75,
                'image_url'   => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200',
                'content'     => json_encode(['blocks' => [
                    ['type' => 'header', 'data' => ['text' => 'Menghadapi Tantangan di Dunia Nyata', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Bekerja secara agile di lingkungan software engineering skala besar memberikan pengalaman berharga mengenai code review, monitoring metric, dan kolaborasi lintas disiplin ilmu.']]
                ]])
            ],
        ];

        foreach ($blogsData as $data) {
            $category = $categories->get($data['category']) ?? BlogCategory::firstOrCreate(
                ['slug' => Str::slug($data['category'])],
                ['name' => $data['category']]
            );

            $blog = Blog::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'blog_category_id' => $category->id,
                    'title'            => $data['title'],
                    'summary'          => $data['summary'],
                    'content'          => $data['content'],
                    'views_count'      => $data['views_count'],
                    'status'           => $data['status'],
                ]
            );

            // Attach media image
            if (!$blog->hasMedia('blog_thumbnails')) {
                try {
                    $blog->addMediaFromUrl($data['image_url'])
                        ->toMediaCollection('blog_thumbnails');
                } catch (\Throwable $e) {
                    $fallback = database_path('seeders/images/dummy.png');
                    if (file_exists($fallback)) {
                        $blog->addMedia($fallback)
                            ->preservingOriginal()
                            ->toMediaCollection('blog_thumbnails');
                    }
                }
            }
        }

        $this->command->info('8 Blog semi-real berhasil dibuat beserta gambar thumbnail!');
    }
}

