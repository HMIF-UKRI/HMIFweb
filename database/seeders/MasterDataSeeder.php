<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\BlogCategory;
use App\Models\Departemen;
use App\Models\EventCategory;
use App\Models\MerchandiseCategory;
use App\Models\PortofolioCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Angkatan Mahasiswa
        $years = ['2021', '2022', '2023', '2024', '2025', '2026'];
        foreach ($years as $year) {
            Angkatan::firstOrCreate(['year' => $year]);
        }

        // 2. Departemen HMIF UKRI
        $departments = [
            'Ring 1' => 'Pimpinan struktural inti yang bertanggung jawab terhadap arah kebijakan, koordinasi umum, serta manajemen strategis HMIF UKRI.',
            'Riset dan Teknologi' => 'Departemen yang berfokus pada eksplorasi riset teknologi mutakhir, software engineering, AI, IoT, serta pengembangan kompetensi keilmuan informatika mahasiswa.',
            'Pengembangan Sumber Daya Manusia' => 'Departemen yang berdedikasi pada kaderisasi, pembinaan karakter, pemberdayaan anggota, pengembangan minat & bakat, serta pengabdian masyarakat.',
            'Media dan Komunikasi' => 'Departemen yang memegang peranan vital dalam strategi branding, publikasi media digital, dokumentasi visual, serta komunikasi relasi publik internal maupun eksternal.'
        ];

        foreach ($departments as $name => $desc) {
            Departemen::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }

        // 3. Bidang (Sub-Departemen)
        $mappingBidang = [
            'Riset dan Teknologi' => [
                'Pendidikan dan Riset Teknologi' => 'Fokus pada penyelenggaraan kelas belajar, riset teknologi, dan pendampingan akademik mahasiswa.',
                'Software dan Web Development'   => 'Fokus pada rekayasa perangkat lunak, web engineering, dan pengembangan sistem aplikasi.'
            ],
            'Pengembangan Sumber Daya Manusia' => [
                'Kaderisasi dan Pengembangan'   => 'Fokus pada pembinaan, mentoring, dan upgrading kapasitas anggota HMIF.',
                'Pengabdian Masyarakat'         => 'Fokus pada bakti sosial, edukasi teknologi ke sekolah, dan program kemasyarakatan.',
                'Minat dan Bakat'               => 'Fokus pada pengembangan potensi minat non-akademik, olahraga, e-sports, dan seni.'
            ],
            'Media dan Komunikasi' => [
                'Humas Internal dan Eksternal'  => 'Fokus pada kemitraan eksternal, advokasi mahasiswa, dan jejaring alumni.',
                'Media Kreatif dan Publikasi'   => 'Fokus pada konten sosial media, desain grafis, videografi, dan publikasi web.'
            ],
        ];

        foreach ($mappingBidang as $deptName => $listBidang) {
            $dept = Departemen::where('name', $deptName)->first();

            if ($dept) {
                foreach ($listBidang as $bName => $bDesc) {
                    Bidang::firstOrCreate([
                        'department_id' => $dept->id,
                        'name'          => $bName,
                    ], [
                        'description'   => $bDesc
                    ]);
                }
            }
        }

        // 4. Kategori Event
        $eventCategories = [
            'Seminar',
            'Workshop',
            'Kompetisi',
            'Talkshow',
            'Pengabdian Masyarakat',
            'Makrab',
            'Sharing Session',
            'Musyawarah',
        ];
        foreach ($eventCategories as $cat) {
            EventCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        // 5. Kategori Blog
        $blogCategories = [
            'Tutorial',
            'Web Development',
            'Cyber Security',
            'Artificial Intelligence',
            'Campus Life',
            'Tech News',
        ];
        foreach ($blogCategories as $cat) {
            BlogCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        // 6. Kategori Merchandise
        $merchandiseCategories = [
            'Apparel',
            'Accessories',
            'Stationery & Stickers',
            'Bundle Kit'
        ];
        foreach ($merchandiseCategories as $cat) {
            MerchandiseCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }

        // 7. Kategori Portofolio
        $portofolioCategories = [
            'Web Application',
            'Mobile Application',
            'UI/UX Design',
            'Artificial Intelligence',
            'IoT & Robotics',
            'Cyber Security'
        ];
        foreach ($portofolioCategories as $cat) {
            PortofolioCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat]
            );
        }
    }
}

