<?php

namespace Database\Seeders;

use App\Models\DocumentEvents;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Models\PeriodeKepengurusan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $categories = EventCategory::all()->keyBy('name');
        $periods    = PeriodeKepengurusan::all()->keyBy('cabinet_name');
        $metaforsa  = $periods->get('MetaForsa') ?? PeriodeKepengurusan::where('is_current', true)->first();
        $digiswara  = $periods->get('Digiswara') ?? PeriodeKepengurusan::first();
        $members    = Member::all();

        if ($members->isEmpty()) {
            $this->command->warn('Tidak ada Member. Jalankan UserMemberSeeder terlebih dahulu.');
            return;
        }

        $eventsData = [
            [
                'title'             => 'Informatics Championship (IFEST) 2026: Code for Future Innovation',
                'category'          => 'Kompetisi',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Haniep Fathan Riziq')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->addMonths(2)->setTime(8, 30),
                'location'          => 'Auditorium Utama Kampus UKRI, Jl. Halimun No. 37 Bandung & Hybrid',
                'whatsapp_group'    => 'https://chat.whatsapp.com/IFEST2026UKRIOfficial',
                'status'            => 'upcoming',
                'local_image'       => 'coc.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1200',
                'short_description' => 'Ajang kompetisi Competitive Programming, UI/UX Design, dan Web Development tingkat nasional yang diselenggarakan oleh HMIF UKRI.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Tentang IFEST 2026 UKRI', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Informatics Championship (IFEST) 2026 merupakan kompetisi teknologi tahunan terbesar yang diadakan oleh Himpunan Mahasiswa Informatika Universitas Kebangsaan Republik Indonesia. Acara ini mewadahi ide-ide inovatif, kemampuan pemecahan masalah algoritma, serta kreativitas desain antarmuka mahasiswa di seluruh Indonesia.']],
                    ['type' => 'header', 'data' => ['text' => 'Kategori Lomba', 'level' => 3]],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'Competitive Programming (Algoritma & Problem Solving)',
                        'UI/UX Design Challenge (Mobile App & Web Solution)',
                        'Web Application Development (Modern Full-Stack Framework)'
                    ]]],
                    ['type' => 'quote', 'data' => ['text' => 'Teknologi adalah sarana untuk mengubah tantangan masa depan menjadi solusi nyata.', 'caption' => 'Ketua Pelaksana IFEST 2026']],
                    ['type' => 'header', 'data' => ['text' => 'Fasilitas & Hadiah Peserta', 'level' => 3]],
                    ['type' => 'list', 'data' => ['style' => 'ordered', 'items' => [
                        'Total hadiah jutaan rupiah & piala bergilir',
                        'E-Sertifikat Nasional ber-SKK untuk seluruh peserta terdaftar',
                        'Merchandise eksklusif IFEST 2026 dan konsumsi bagi finalis luring',
                        'Sesi networking dan mentorship langsung bersama praktisi software house terkemuka'
                    ]]]
                ],
                'registrations' => [
                    ['name' => 'Dimas Aditya Nugraha', 'email' => 'dimas.aditya@student.ukri.ac.id', 'phone' => '081234112233', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2024', 'notes' => 'Mendaftar kategori Competitive Programming'],
                    ['name' => 'Sarah Amanda Putri', 'email' => 'sarah.amanda@itb.ac.id', 'phone' => '081398776655', 'inst' => 'Institut Teknologi Bandung', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2023', 'notes' => 'Tim UI/UX Designer'],
                    ['name' => 'Fathur Rahman Hakim', 'email' => 'fathur.rahman@telkomuniversity.ac.id', 'phone' => '082155443322', 'inst' => 'Telkom University', 'cat' => 'Mahasiswa', 'major' => 'Sistem Informasi', 'batch' => '2023', 'notes' => 'Mendaftar Web Dev Competition'],
                    ['name' => 'Rian Maulana', 'email' => 'rian.maulana@smkn4bdg.sch.id', 'phone' => '085711223344', 'inst' => 'SMK Negeri 4 Bandung', 'cat' => 'Pelajar', 'major' => 'Rekayasa Perangkat Lunak', 'batch' => '2024', 'notes' => 'Peserta jalur siswa SMK'],
                    ['name' => 'Anisa Rahmawati', 'email' => 'anisa.rahmawati@unpad.ac.id', 'phone' => '081977889900', 'inst' => 'Universitas Padjadjaran', 'cat' => 'Mahasiswa', 'major' => 'Ilmu Komputer', 'batch' => '2024', 'notes' => 'Mengikuti workshop pembuka dan lomba'],
                ]
            ],
            [
                'title'             => 'Workshop Full-Stack Web: Mastering Laravel 12 & Vue 3 Modern Stack',
                'category'          => 'Workshop',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Haris Ramdhani')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->addDays(14)->setTime(9, 0),
                'location'          => 'Lab Komputer 3, Gedung B Lantai 2 Kampus UKRI',
                'whatsapp_group'    => 'https://chat.whatsapp.com/WorkshopFullstackHMIF2026',
                'status'            => 'upcoming',
                'local_image'       => 'coc.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=1200',
                'short_description' => 'Pelatihan intensif praktik langsung pembuatan REST API dengan Laravel 12 dan antarmuka reaktif modern menggunakan Vue 3 & Tailwind CSS.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Silabus Workshop', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Workshop ini dirancang untuk mahasiswa yang ingin mendalami arsitektur web modern full-stack dari hulu ke hilir. Peserta akan dibimbing membuat aplikasi web interaktif mulai dari setup backend database hingga deployment.']],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'Pengenalan arsitektur baru & performance optimization pada Laravel 12',
                        'Desain RESTful API, otentikasi Sanctum, dan validasi data terstruktur',
                        'Membangun UI SPA/SSR dengan Vue 3 Composition API & Pinia Store',
                        'Integrasi real-time update dan best practice clean architecture'
                    ]]],
                    ['type' => 'quote', 'data' => ['text' => 'Kuasai fundamental, eksplorasi framework modern, dan bangun portofolio terbaikmu.', 'caption' => 'Departemen Ristek HMIF UKRI']]
                ],
                'registrations' => [
                    ['name' => 'Muhammad Aditya', 'email' => 'm.aditya@student.ukri.ac.id', 'phone' => '081299887711', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2024', 'notes' => 'Membawa laptop sendiri'],
                    ['name' => 'Clara Novita', 'email' => 'clara.novita@student.ukri.ac.id', 'phone' => '081388776622', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2025', 'notes' => 'Ingin belajar backend Laravel'],
                    ['name' => 'Budi Santoso', 'email' => 'budi.santoso@upi.edu', 'phone' => '085611335577', 'inst' => 'Universitas Pendidikan Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Ilmu Komputer', 'batch' => '2023', 'notes' => 'Peserta umum eksternal'],
                    ['name' => 'Dewi Anggraini', 'email' => 'dewi.anggraini@polban.ac.id', 'phone' => '087822446688', 'inst' => 'Politeknik Negeri Bandung', 'cat' => 'Mahasiswa', 'major' => 'Teknik Komputer', 'batch' => '2024', 'notes' => 'Tertarik integrasi Vue 3'],
                ]
            ],
            [
                'title'             => 'Tech Talk: Artificial Intelligence & Cloud Native Architecture in Industry',
                'category'          => 'Talkshow',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Mochamad Dzaki Ramadhan')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->addDays(28)->setTime(13, 30),
                'location'          => 'Ruang Multimedia Lantai 3 UKRI & Live YouTube HMIF UKRI',
                'whatsapp_group'    => 'https://chat.whatsapp.com/TechTalkAIHMIFUKRI',
                'status'            => 'upcoming',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1200',
                'short_description' => 'Diskusi interaktif bersama Senior AI Engineer dan Cloud Solutions Architect mengenai implementasi GenAI & Cloud di dunia kerja.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Highlight Sesi Tech Talk', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Bagaimana perusahaan teknologi global memanfaatkan Large Language Models (LLM) dan microservices berbasis Kubernetes untuk melayani jutaan pengguna secara andal? Temukan jawabannya pada sesi Tech Talk HMIF ini.']],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'Peluang karir AI Engineer, Data Scientist, dan DevOps di era 2026',
                        'Arsitektur cloud native scalable dengan Docker, Kubernetes, dan CI/CD pipeline',
                        'Studi kasus pemanfaatan multimodal AI API pada startup teknologi'
                    ]]]
                ],
                'registrations' => [
                    ['name' => 'Kevin Pratama', 'email' => 'kevin.pratama@student.ukri.ac.id', 'phone' => '081233445566', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2023', 'notes' => 'Peserta offline'],
                    ['name' => 'Rina Marlina', 'email' => 'rina.marlina@gmail.com', 'phone' => '081377889900', 'inst' => 'PT Digital Solusi Bangsa', 'cat' => 'Pekerja', 'major' => 'Software Engineer', 'batch' => null, 'notes' => 'Ingin update trend cloud architecture'],
                ]
            ],
            [
                'title'             => 'Malam Keakraban (MAKRAB) Informatika 2025: Unity in Diversity',
                'category'          => 'Makrab',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Reyfasha Fadlan Azizan')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(3)->setTime(15, 0),
                'location'          => 'Villa Istana Bunga, Lembang, Kab. Bandung Barat',
                'whatsapp_group'    => 'https://chat.whatsapp.com/MakrabInformatika2025',
                'status'            => 'completed',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200',
                'short_description' => 'Kegiatan tahunan pengakraban dan penyambutan mahasiswa baru Informatika UKRI untuk membangun rasa solidaritas, kekeluargaan, dan integritas.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Rangkaian Agenda Makrab', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Malam Keakraban Informatika 2025 sukses diselenggarakan di Lembang dengan partisipasi lebih dari 150 mahasiswa dan alumni dari angkatan 2021 hingga 2025. Kegiatan diisi dengan sharing session alumni, games kekompakan, pentas seni, dan api unggun kebersamaan.']],
                    ['type' => 'quote', 'data' => ['text' => 'Bukan tentang seberapa jauh kita melangkah sendiri, tetapi seberapa kompak kita melangkah bersama sebagai keluarga besar Informatika.', 'caption' => 'Ketua HMIF MetaForsa']]
                ]
            ],
            [
                'title'             => 'HMIF Mengabdi 2025: Literasi Digital & Coding Fundamental di SMKN 4 Bandung',
                'category'          => 'Pengabdian Masyarakat',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Putu Alif Milanarsa')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(4)->setTime(8, 0),
                'location'          => 'SMK Negeri 4 Bandung, Jl. Kliningan No. 6, Lengkong, Bandung',
                'whatsapp_group'    => 'https://chat.whatsapp.com/HMIFMengabdi2025',
                'status'            => 'completed',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200',
                'short_description' => 'Bakti sosial dan pelatihan dasar pemrograman web untuk siswa SMK guna meningkatkan kesiapan keterampilan digital generasi muda.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Laporan Singkat Pengabdian', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'HMIF Mengabdi merupakan wujud implementasi Tri Dharma Perguruan Tinggi dalam aspek Pengabdian kepada Masyarakat. Tim mahasiswa HMIF memberikan modul interaktif HTML, CSS, JavaScript, serta pengenalan dasar keamanan siber kepada 60 siswa jurusan Rekayasa Perangkat Lunak.']]
                ]
            ],
            [
                'title'             => 'Seminar Nasional Cyber Security: Defensive Security & Threat Analysis',
                'category'          => 'Seminar',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Naya Fitri Nazwa Nur Haliza')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(2)->setTime(9, 0),
                'location'          => 'Aula Jenderal Sudirman Lantai 2, Kampus UKRI Bandung',
                'whatsapp_group'    => 'https://chat.whatsapp.com/SemnasCyberSecHMIF',
                'status'            => 'completed',
                'local_image'       => 'coc.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200',
                'short_description' => 'Seminar nasional membahas strategi pertahanan infrastruktur data, incident response, dan kesiapan talenta cyber security nasional.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Ringkasan Materi Seminar', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Seminar ini menghadirkan pembicara dari praktisi CERT dan industri perbankan nasional yang mengupas tuntas ancaman ransomware, mitigasi kebocoran data, dan teknik SOC analysis.']]
                ]
            ],
            [
                'title'             => 'Clash of Code (CoC) HMIF UKRI 2026: Fast-Paced Coding Challenge',
                'category'          => 'Kompetisi',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Haniep Fathan Riziq')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(1)->setTime(13, 0),
                'location'          => 'Lab Pemrograman Komputer UKRI & Online Judge System',
                'whatsapp_group'    => 'https://chat.whatsapp.com/ClashOfCodeHMIF2026',
                'status'            => 'completed',
                'local_image'       => 'coc.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=1200',
                'short_description' => 'Kompetisi adu kecepatan dan efisiensi algoritma pemrograman antar mahasiswa informatika dalam format 15-minute speed code rounds.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Keseruan Clash of Code 2026', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Turnamen coding kilat yang menguji ketajaman logika, optimasi kompleksitas Big-O, dan ketepatan sintaks dalam bahasa C++, Python, dan Java di bawah tekanan waktu ketat.']]
                ]
            ],
            [
                'title'             => 'Diskusi Publik: Kolaborasi Mahasiswa IT dalam Ekosistem Smart City Bandung',
                'category'          => 'Talkshow',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Maulana Yusuf')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subWeeks(3)->setTime(15, 30),
                'location'          => 'Basecamp HMIF UKRI, Kampus Halimun Bandung',
                'whatsapp_group'    => 'https://chat.whatsapp.com/DiskusiPublikHMIFUKRI',
                'status'            => 'completed',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=1200',
                'short_description' => 'Forum diskusi strategis mahasiswa informatika mengenai peran teknologi open data, IoT perkotaan, dan transportasi cerdas di Kota Bandung.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Poin Hasil Diskusi', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Membahas peluang kolaborasi riset mahasiswa dengan dinas terkait dalam optimalisasi sistem pemantauan lalu lintas dan aplikasi layanan publik warga.']]
                ]
            ],
            [
                'title'             => 'Sharing Session: Strategi Lolos Magang & MSIB di Top Tech Company',
                'category'          => 'Sharing Session',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Tania Cahyani P')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->addDays(7)->setTime(19, 30),
                'location'          => 'Google Meet & Zoom Meeting HMIF UKRI',
                'whatsapp_group'    => 'https://chat.whatsapp.com/SharingMagangMSIBHMIF',
                'status'            => 'upcoming',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200',
                'short_description' => 'Tips membedah CV ATS, technical interview, take-home test coding, dan portofolio GitHub langsung dari mahasiswa berprestasi alumni MSIB.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Agenda Sharing Session', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Dapatkan insight eksklusif tentang proses seleksi mitra magang bergengsi seperti GoTo, Traveloka, Shopee, Telkom, dan Dicoding.']],
                    ['type' => 'list', 'data' => ['style' => 'unordered', 'items' => [
                        'Review template CV Tech standar industri',
                        'Simulasi live coding & algorithmic interview question',
                        'Trik membangun portofolio proyek full-stack yang menarik perhatian recruiter'
                    ]]]
                ],
                'registrations' => [
                    ['name' => 'Fajri Nurhidayat', 'email' => 'fajri.nur@student.ukri.ac.id', 'phone' => '081244556677', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2023', 'notes' => 'Target magang backend developer'],
                    ['name' => 'Indah Permatasari', 'email' => 'indah.permata@student.ukri.ac.id', 'phone' => '081355667788', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2024', 'notes' => 'Target magang UI/UX'],
                    ['name' => 'Aldi Taher', 'email' => 'aldi.taher@student.ukri.ac.id', 'phone' => '085766778899', 'inst' => 'Universitas Kebangsaan Republik Indonesia', 'cat' => 'Mahasiswa', 'major' => 'Teknik Informatika', 'batch' => '2024', 'notes' => 'Ingin tahu tips interview HR'],
                ]
            ],
            [
                'title'             => 'Sahur on The Road (SOTR) & Bakti Sosial Ramadhan 1447H HMIF UKRI',
                'category'          => 'Pengabdian Masyarakat',
                'period'            => $metaforsa,
                'lead_member'       => $members->where('full_name', 'Alamudin Sdaka')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(5)->setTime(2, 30),
                'location'          => 'Rute Kota Bandung & Panti Asuhan Al-Kautsar Bandung',
                'whatsapp_group'    => 'https://chat.whatsapp.com/SOTRHMIFUKRI2026',
                'status'            => 'completed',
                'local_image'       => 'sotr.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=1200',
                'short_description' => 'Aksi kepedulian sosial mahasiswa informatika membagikan santapan sahur kepada kaum dhuafa dan menyalurkan donasi ke panti asuhan.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Dokumentasi & Makna Kegiatan', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Alhamdulillah, kegiatan SOTR dan Bakti Sosial Ramadhan berjalan lancar dengan penyaluran lebih dari 250 paket makanan sahur dan bantuan paket sembako serta perlengkapan sekolah bagi anak-anak panti.']]
                ]
            ],
            [
                'title'             => 'Bootcamp Python for Data Science & Machine Learning',
                'category'          => 'Workshop',
                'period'            => $digiswara,
                'lead_member'       => $members->where('full_name', 'Chriss Hendry Choong')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(8)->setTime(9, 0),
                'location'          => 'Lab Komputer UKRI & Google Colab Online',
                'whatsapp_group'    => 'https://chat.whatsapp.com/BootcampPythonHMIF',
                'status'            => 'completed',
                'local_image'       => 'coc.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200',
                'short_description' => 'Bootcamp 3 hari mempelajari dasar analisis data, visualisasi data dengan Pandas & Matplotlib, serta modeling klasifikasi scikit-learn.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Materi Bootcamp Data Science', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'Peserta mempelajari teknik data preprocessing, exploratory data analysis (EDA), dan pembuatan model machine learning dasar untuk prediksi data tabular.']]
                ]
            ],
            [
                'title'             => 'Musyawarah Besar (MUBES) HMIF UKRI: Suksesi Kepemimpinan & AD/ART',
                'category'          => 'Musyawarah',
                'period'            => $digiswara,
                'lead_member'       => $members->where('full_name', 'Muhammad Ikhsan Kamil')->first() ?? $members->first(),
                'event_date'        => Carbon::now()->subMonths(10)->setTime(8, 0),
                'location'          => 'Ruang Sidang Utama UKRI, Kampus Halimun Bandung',
                'whatsapp_group'    => 'https://chat.whatsapp.com/MUBESHMIFUKRI',
                'status'            => 'completed',
                'local_image'       => 'diskusi publik.jpg',
                'remote_image'      => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=1200',
                'short_description' => 'Forum musyawarah tertinggi mahasiswa informatika untuk evaluasi laporan pertanggungjawaban kepengurusan, amandemen AD/ART, dan pemilihan ketua himpunan.',
                'content_blocks'    => [
                    ['type' => 'header', 'data' => ['text' => 'Ketetapan Sidang Pleno MUBES', 'level' => 2]],
                    ['type' => 'paragraph', 'data' => ['text' => 'MUBES berhasil mengesahkan LPJ kepengurusan periode sebelumnya serta menetapkan Ketua Himpunan terpilih untuk menahkodai kepengurusan periode baru.']]
                ]
            ],
        ];

        foreach ($eventsData as $item) {
            $cat = $categories->get($item['category']) ?? EventCategory::firstOrCreate(
                ['slug' => Str::slug($item['category'])],
                ['name' => $item['category']]
            );

            $period = $item['period'] ?? $metaforsa;
            $leadMember = $item['lead_member'] ?? $members->first();

            $event = Event::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'event_category_id'  => $cat->id,
                    'period_id'          => $period->id,
                    'member_id'          => $leadMember->id,
                    'title'              => $item['title'],
                    'short_description'  => $item['short_description'],
                    'description'        => json_encode(['blocks' => $item['content_blocks']]),
                    'event_date'         => $item['event_date'],
                    'location'           => $item['location'],
                    'whatsapp_group_link'=> $item['whatsapp_group'],
                    'status'             => $item['status'],
                ]
            );

            // Spatie Media Library: Thumbnail Event
            if (!$event->hasMedia('thumbnails')) {
                $attached = false;

                // 1. Coba attach gambar lokal spesifik
                if (!empty($item['local_image'])) {
                    $localPath = database_path('seeders/images/' . $item['local_image']);
                    if (file_exists($localPath)) {
                        try {
                            $event->addMedia($localPath)
                                ->preservingOriginal()
                                ->toMediaCollection('thumbnails');
                            $attached = true;
                        } catch (\Throwable $e) {
                            // Abaikan dan coba cara lain
                        }
                    }
                }

                // 2. Jika belum ter-attach dan ada URL remote
                if (!$attached && !empty($item['remote_image'])) {
                    try {
                        $event->addMediaFromUrl($item['remote_image'])
                            ->toMediaCollection('thumbnails');
                        $attached = true;
                    } catch (\Throwable $e) {
                        // Fallback ke dummy lokal jika offline
                        $fallback = database_path('seeders/images/dummy.png');
                        if (file_exists($fallback)) {
                            $event->addMedia($fallback)
                                ->preservingOriginal()
                                ->toMediaCollection('thumbnails');
                        }
                    }
                }
            }

            // Seeding Data Pendaftaran Peserta (EventRegistration)
            if (!empty($item['registrations'])) {
                foreach ($item['registrations'] as $reg) {
                    EventRegistration::updateOrCreate(
                        ['event_id' => $event->id, 'email' => $reg['email']],
                        [
                            'full_name'            => $reg['name'],
                            'phone'                => $reg['phone'],
                            'institution'          => $reg['inst'],
                            'participant_category' => $reg['cat'],
                            'major'                => $reg['major'],
                            'batch'                => $reg['batch'],
                            'notes'                => $reg['notes'],
                        ]
                    );
                }
            }

            // Seeding Data Peserta / Kehadiran untuk Event Selesai
            if ($event->status === 'completed' && EventRegistration::where('event_id', $event->id)->count() <= 3) {
                // Internal members
                $randomInternalMembers = $members->random(min(5, $members->count()));
                foreach ($randomInternalMembers as $im) {
                    EventRegistration::firstOrCreate(
                        ['event_id' => $event->id, 'email' => $im->user?->email ?? Str::slug($im->full_name) . '@student.ukri.ac.id'],
                        [
                            'full_name'            => $im->full_name,
                            'phone'                => $im->user?->no_hp ?? '0812' . rand(10000000, 99999999),
                            'institution'          => 'Universitas Kebangsaan Republik Indonesia',
                            'participant_category' => 'Mahasiswa',
                            'major'                => $im->department?->name ?? 'Teknik Informatika',
                            'batch'                => (string) ($im->generation?->year ?? '2023'),
                            'notes'                => 'Kehadiran Anggota HMIF',
                            'certificate_sent_at'  => Carbon::parse($event->event_date)->addDays(1),
                        ]
                    );
                }

                // External participants
                $externalParticipants = [
                    ['name' => 'Faisal Rahman', 'email' => 'faisal.rahman@gmail.com', 'phone' => '082111223344', 'inst' => 'Universitas Padjadjaran', 'cat' => 'Mahasiswa', 'major' => 'Informatika', 'batch' => '2023', 'notes' => 'Peserta Umum'],
                    ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@smk.sch.id', 'phone' => '085811223344', 'inst' => 'SMKN 4 Bandung', 'cat' => 'Pelajar', 'major' => 'RPL', 'batch' => '2024', 'notes' => 'Minat Web Dev'],
                    ['name' => 'Andi Wijaya', 'email' => 'andi.wijaya@techcorp.id', 'phone' => '087711223344', 'inst' => 'PT Teknologi Maju Bersama', 'cat' => 'Pekerja', 'major' => null, 'batch' => null, 'notes' => 'Networking industri'],
                ];

                foreach ($externalParticipants as $ep) {
                    EventRegistration::firstOrCreate(
                        ['event_id' => $event->id, 'email' => $ep['email']],
                        [
                            'full_name'            => $ep['name'],
                            'phone'                => $ep['phone'],
                            'institution'          => $ep['inst'],
                            'participant_category' => $ep['cat'],
                            'major'                => $ep['major'],
                            'batch'                => $ep['batch'],
                            'notes'                => $ep['notes'],
                            'certificate_sent_at'  => Carbon::parse($event->event_date)->addDays(1),
                        ]
                    );
                }
            }

            // Seeding Arsip Dokumen Kegiatan (DocumentEvents)
            if (DocumentEvents::where('event_id', $event->id)->count() === 0) {
                DocumentEvents::create([
                    'event_id'      => $event->id,
                    'period_id'     => $event->period_id,
                    'type_document' => 'proposal',
                    'name'          => 'Proposal Kegiatan ' . $event->title . '.pdf',
                ]);

                if ($event->status === 'completed') {
                    DocumentEvents::create([
                        'event_id'      => $event->id,
                        'period_id'     => $event->period_id,
                        'type_document' => 'lpj',
                        'name'          => 'Laporan Pertanggungjawaban (LPJ) ' . $event->title . '.pdf',
                    ]);
                }
            }
        }

        $this->command->info('12 Data Event semi-real beserta Pendaftaran, Absensi, dan Dokumen berhasil dibuat!');
    }
}
