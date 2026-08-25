<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Portofolio;
use App\Models\PortofolioCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        $categories = PortofolioCategory::all()->keyBy('name');
        $members    = Member::all();

        if ($members->isEmpty()) {
            $this->command->warn('Tidak ada Member. Jalankan UserMemberSeeder terlebih dahulu.');
            return;
        }

        $projects = [
            [
                'title'       => 'SIM-HMIF (Sistem Informasi Manajemen HMIF UKRI)',
                'category'    => 'Web Application',
                'author'      => $members->where('full_name', 'Haniep Fathan Riziq')->first() ?? $members->first(),
                'description' => 'Aplikasi web portal terpadu untuk pengelolaan data keanggotaan, arsip dokumen LPJ/Proposal, presensi barcode event, dan e-commerce merchandise resmi HMIF UKRI.',
                'image_url'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/sim-hmif',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => true,
                'status'      => 'Published',
            ],
            [
                'title'       => 'Informatics Event QR Attendance Mobile App',
                'category'    => 'Mobile Application',
                'author'      => $members->where('full_name', 'Mochamad Dzaki Ramadhan')->first() ?? $members->first(),
                'description' => 'Aplikasi mobile berbasis Flutter dan REST API untuk scan QR Code kehadiran peserta kegiatan secara real-time dengan integrasi geofencing lokasi kampus.',
                'image_url'   => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/event-qr-attendance',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => true,
                'status'      => 'Published',
            ],
            [
                'title'       => 'Smart Greenhouse IoT Monitoring & Automation System',
                'category'    => 'IoT & Robotics',
                'author'      => $members->where('full_name', 'Haris Ramdhani')->first() ?? $members->first(),
                'description' => 'Sistem monitoring suhu, kelembaban tanah, dan penyiraman otomatis berbasis mikrokontroler ESP32 dengan protokol MQTT dan dashboard visualisasi web.',
                'image_url'   => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/smart-greenhouse-iot',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => true,
                'status'      => 'Published',
            ],
            [
                'title'       => 'AI-Powered Automated Resume Matcher & Screener',
                'category'    => 'Artificial Intelligence',
                'author'      => $members->where('full_name', 'Putu Alif Milanarsa')->first() ?? $members->first(),
                'description' => 'Model NLP berbasis Python FastAPI dan embedding transformer untuk mencocokkan kualifikasi CV kandidat dengan requirements lowongan pekerjaan secara otomatis.',
                'image_url'   => 'https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/ai-resume-matcher',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => false,
                'status'      => 'Published',
            ],
            [
                'title'       => 'Redesign UI/UX Portal Akademik Mahasiswa UKRI',
                'category'    => 'UI/UX Design',
                'author'      => $members->where('full_name', 'Naya Fitri Nazwa Nur Haliza')->first() ?? $members->first(),
                'description' => 'Riset dan perancangan ulang antarmuka sistem informasi akademik kampus dengan pendekatan Human-Centered Design (HCD) dan design system Figma yang modern.',
                'image_url'   => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/redesign-portal-ukri',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => true,
                'status'      => 'Published',
            ],
            [
                'title'       => 'Campus Network Vulnerability Scanner CLI',
                'category'    => 'Cyber Security',
                'author'      => $members->where('full_name', 'Maulana Yusuf')->first() ?? $members->first(),
                'description' => 'Tool pemindai port terbuka, analisis kerentanan konfigurasi jaringan lokal, dan generator laporan audit keamanan jaringan kampus berbasis Python Scapy.',
                'image_url'   => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800',
                'url_github'  => 'https://github.com/hmif-ukri/network-vuln-scanner',
                'url_linkedin'=> 'https://linkedin.com/company/hmif-ukri',
                'is_featured' => false,
                'status'      => 'Published',
            ],
        ];

        foreach ($projects as $item) {
            $category = $categories->get($item['category']) ?? PortofolioCategory::firstOrCreate(
                ['slug' => Str::slug($item['category'])],
                ['name' => $item['category']]
            );

            $author = $item['author'] ?? $members->first();

            $portofolio = Portofolio::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'portofolio_category_id' => $category->id,
                    'member_id'              => $author->id,
                    'title'                  => $item['title'],
                    'description'            => $item['description'],
                    'thumbnail'              => $item['image_url'],
                    'is_featured'            => $item['is_featured'],
                    'url_github'             => $item['url_github'],
                    'url_linkedin'           => $item['url_linkedin'],
                    'status'                 => $item['status'],
                ]
            );

            if (!$portofolio->hasMedia('default')) {
                try {
                    $portofolio->addMediaFromUrl($item['image_url'])
                        ->toMediaCollection('default');
                } catch (\Throwable $e) {
                    $fallback = database_path('seeders/images/dummy.png');
                    if (file_exists($fallback)) {
                        $portofolio->addMedia($fallback)
                            ->preservingOriginal()
                            ->toMediaCollection('default');
                    }
                }
            }
        }

        $this->command->info('6 Portofolio proyek mahasiswa HMIF UKRI berhasil dibuat!');
    }
}
