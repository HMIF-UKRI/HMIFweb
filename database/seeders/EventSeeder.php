<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     $categoryIds = EventCategory::pluck('id')->all();

    //     if (empty($categoryIds)) {
    //         $this->command->error('No event categories found. Please run the EventCategorySeeder first.');
    //         return;
    //     }

    //     $destinationPath = 'event/thumbnails';

    //     Storage::disk('public')->deleteDirectory($destinationPath);
    //     Storage::disk('public')->makeDirectory($destinationPath);

    //     $eventsData = [
    //         [
    //             'title' => 'Click On Code',
    //             'thumbnail_path' => 'coc.jpg',
    //             'short_description' => 'A coding workshop for beginners.',
    //             'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
    //             'event_date' => Date::now()->subDays(10),
    //             'location' => 'SMA 16 Bandung',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Sahur On The Road',
    //             'thumbnail_path' => 'sotr.jpg',
    //             'short_description' => 'A community service event during Ramadan.',
    //             'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
    //             'event_date' => Date::now()->subMonths(2),
    //             'location' => 'Bandung City',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Diskusi Publik HMIF',
    //             'thumbnail_path' => 'diskusi publik.jpg',
    //             'short_description' => 'A public discussion event organized by HMIF.',
    //             'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
    //             'event_date' => Date::now()->subWeeks(3),
    //             'location' => 'Garasi Cempor',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Workshop UI/UX Design',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Hands-on workshop for UI/UX design fundamentals.',
    //             'description' => 'Detail lengkap tentang workshop UI/UX Design, mencakup materi, pembicara, dan manfaat yang didapatkan peserta. Fokus pada praktik langsung dan studi kasus industri.',
    //             'event_date' => Date::now()->addDays(5),
    //             'location' => 'Lab Komputer A',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'HMIF Cup Futsal',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Annual futsal tournament for HMIF members.',
    //             'description' => 'Turnamen futsal tahunan untuk mempererat tali silaturahmi antar anggota HMIF. Ajang kompetisi dan kebersamaan.',
    //             'event_date' => Date::now()->addWeeks(2),
    //             'location' => 'GOR Futsal Kampus',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Seminar Karir IT',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Exploring career paths in the IT industry.',
    //             'description' => 'Seminar yang membahas berbagai jalur karir di industri IT, tips sukses, dan sesi tanya jawab dengan praktisi profesional.',
    //             'event_date' => Date::now()->addMonths(1),
    //             'location' => 'Auditorium Utama',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Pelatihan Dasar Pemrograman Web',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Basic web programming training for beginners.',
    //             'description' => 'Pelatihan intensif untuk memahami dasar-dasar pemrograman web, mulai dari HTML, CSS, hingga JavaScript.',
    //             'event_date' => Date::now()->addMonths(1)->addDays(15),
    //             'location' => 'Ruang Kelas 301',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Bakti Sosial HMIF',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Community service activity to help those in need.',
    //             'description' => 'Kegiatan bakti sosial rutin HMIF untuk membantu masyarakat sekitar, meliputi penggalangan dana dan distribusi bantuan.',
    //             'event_date' => Date::now()->addMonths(3),
    //             'location' => 'Desa Mekar Jaya',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Rapat Rutin Departemen Akademik',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Regular meeting for Academic Department members.',
    //             'description' => 'Rapat koordinasi rutin departemen akademik untuk membahas program kerja dan evaluasi kegiatan.',
    //             'event_date' => Date::now()->subDays(2),
    //             'location' => 'Sekre HMIF',
    //             'status' => 'routine',
    //         ],
    //         [
    //             'title' => 'Kajian Rutin Informatika',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Weekly discussion on current IT topics.',
    //             'description' => 'Diskusi mingguan tentang tren dan isu terkini di dunia informatika, terbuka untuk semua anggota.',
    //             'event_date' => Date::now()->subDays(5),
    //             'location' => 'Perpustakaan Kampus',
    //             'status' => 'routine',
    //         ],
    //         [
    //             'title' => 'Pekan Olahraga Mahasiswa (POM) IT',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Annual sports week for IT students.',
    //             'description' => 'Ajang kompetisi olahraga antar mahasiswa IT, meliputi berbagai cabang olahraga.',
    //             'event_date' => Date::now()->subMonths(6),
    //             'location' => 'Komplek Olahraga Kampus',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Malam Keakraban HMIF',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Annual gathering to strengthen bonds among members.',
    //             'description' => 'Acara puncak untuk mempererat tali persaudaraan dan keakraban antar anggota HMIF, diisi dengan games dan hiburan.',
    //             'event_date' => Date::now()->subMonths(10),
    //             'location' => 'Villa Puncak',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Hackathon HMIF 2024',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => '24-hour coding competition.',
    //             'description' => 'Kompetisi coding intensif selama 24 jam untuk mengembangkan solusi inovatif.',
    //             'event_date' => Date::now()->addDays(20),
    //             'location' => 'Gedung Serbaguna',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Pelatihan Jaringan Komputer',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Training on computer networking basics.',
    //             'description' => 'Pelatihan dasar-dasar jaringan komputer, konfigurasi, dan troubleshooting.',
    //             'event_date' => Date::now()->addMonths(2),
    //             'location' => 'Lab Jaringan',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Webinar Data Science',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Online seminar about data science and its applications.',
    //             'description' => 'Webinar daring yang membahas konsep dasar dan aplikasi ilmu data di berbagai industri.',
    //             'event_date' => Date::now()->addWeeks(1),
    //             'location' => 'Online (Zoom)',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'HMIF Goes to School',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Introducing IT to high school students.',
    //             'description' => 'Program pengenalan dunia IT dan HMIF kepada siswa SMA/SMK di berbagai sekolah.',
    //             'event_date' => Date::now()->addMonths(4),
    //             'location' => 'Berbagai SMA/SMK',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'Rapat Koordinasi Pengurus Harian',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Daily executive board coordination meeting.',
    //             'description' => 'Rapat koordinasi rutin pengurus harian untuk memastikan kelancaran operasional himpunan.',
    //             'event_date' => Date::now()->subDays(1),
    //             'location' => 'Ruang Rapat HMIF',
    //             'status' => 'routine',
    //         ],
    //         [
    //             'title' => 'Studi Kasus Cyber Security',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'In-depth analysis of cyber security incidents.',
    //             'description' => 'Pembahasan mendalam tentang studi kasus keamanan siber dan cara penanganannya.',
    //             'event_date' => Date::now()->addWeeks(3),
    //             'location' => 'Ruang Diskusi',
    //             'status' => 'upcoming',
    //         ],
    //         [
    //             'title' => 'HMIF Peduli Lingkungan',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Environmental awareness campaign and clean-up.',
    //             'description' => 'Kampanye kesadaran lingkungan dan kegiatan bersih-bersih area kampus.',
    //             'event_date' => Date::now()->subMonths(1),
    //             'location' => 'Area Kampus',
    //             'status' => 'completed',
    //         ],
    //         [
    //             'title' => 'Lomba Desain Poster Digital',
    //             'thumbnail_path' => 'dummy.png',
    //             'short_description' => 'Digital poster design competition for students.',
    //             'description' => 'Kompetisi desain poster digital dengan tema inovasi teknologi.',
    //             'event_date' => Date::now()->addMonths(1)->addWeeks(1),
    //             'location' => 'Online',
    //             'status' => 'upcoming',
    //         ],
    //     ];

    //     $dataToInsert = [];

    //     foreach ($eventsData as $data) {
    //         $sourceFilePath = database_path('seeders/images/' . $data['thumbnail_path']);

    //         $newFileName = Str::slug($data['title']) . '.' . pathinfo($data['thumbnail_path'], PATHINFO_EXTENSION);
    //         $newFilePath = $destinationPath . '/' . $newFileName;

    //         if (file_exists($sourceFilePath)) {
    //             Storage::disk('public')->put($newFilePath, file_get_contents($sourceFilePath));
    //         } else {
    //             $this->command->warn("Thumbnail file not found: " . $data['thumbnail_path'] . ". Using a placeholder path.");
    //             $newFilePath = 'event/thumbnails/placeholder.jpg';
    //         }


    //         $dataToInsert[] = [
    //             'title' => $data['title'],
    //             'slug' => Str::slug($data['title']),
    //             'description' => $data['description'],
    //             'short_description' => $data['short_description'],
    //             'thumbnail_path' => $newFilePath,
    //             'event_date' => $data['event_date'],
    //             'location' => $data['location'],
    //             'status' => $data['status'],
    //             'event_category_id' => $categoryIds[array_rand($categoryIds)],
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }

    //     Event::insert($dataToInsert);

    //     $this->command->info(count($dataToInsert) . ' events have been seeded!');
    // }

    public function run(): void
    {
        if (EventCategory::count() === 0) {
            $this->call(EventCategorySeeder::class);
        }

        $this->command->info('Sedang membuat 10 data event beserta gambarnya...');

        Event::factory()->count(15)->create();

        $this->command->info('10 data event berhasil dibuat!');
    }
}
