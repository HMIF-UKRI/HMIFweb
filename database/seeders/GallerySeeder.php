<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\Member;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $events  = Event::all();
        $members = Member::all();

        if ($events->isEmpty() || $members->isEmpty()) {
            $this->command->warn('Event atau Member belum ada. Lewati GallerySeeder.');
            return;
        }

        $galleryData = [
            [
                'event_title'  => 'Malam Keakraban (MAKRAB) Informatika 2025: Unity in Diversity',
                'caption'      => 'Foto Bersama Peserta dan Panitia MAKRAB Informatika 2025 di Villa Istana Bunga Lembang',
                'is_featured'  => true,
                'local_image'  => 'diskusi publik.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200',
            ],
            [
                'event_title'  => 'Clash of Code (CoC) HMIF UKRI 2026: Fast-Paced Coding Challenge',
                'caption'      => 'Suasana Kompetisi Kecepatan Algoritma Clash of Code di Lab Pemrograman UKRI',
                'is_featured'  => true,
                'local_image'  => 'coc.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1200',
            ],
            [
                'event_title'  => 'Sahur on The Road (SOTR) & Bakti Sosial Ramadhan 1447H HMIF UKRI',
                'caption'      => 'Pemberian Santunan dan Sembako pada Kegiatan Bakti Sosial Ramadhan di Panti Asuhan',
                'is_featured'  => true,
                'local_image'  => 'sotr.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=1200',
            ],
            [
                'event_title'  => 'Diskusi Publik: Kolaborasi Mahasiswa IT dalam Ekosistem Smart City Bandung',
                'caption'      => 'Sesi Diskusi Terbuka dan Tanya Jawab Seputar Inovasi Smart City di Basecamp HMIF UKRI',
                'is_featured'  => false,
                'local_image'  => 'diskusi publik.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=1200',
            ],
            [
                'event_title'  => 'HMIF Mengabdi 2025: Literasi Digital & Coding Fundamental di SMKN 4 Bandung',
                'caption'      => 'Pendampingan Praktik Coding Web Dasar Siswa SMKN 4 Bandung oleh Instruktur HMIF',
                'is_featured'  => true,
                'local_image'  => 'coc.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200',
            ],
            [
                'event_title'  => 'Seminar Nasional Cyber Security: Defensive Security & Threat Analysis',
                'caption'      => 'Penyerahan Plakat Penghargaan kepada Pemateri Seminar Nasional Cyber Security UKRI',
                'is_featured'  => false,
                'local_image'  => 'coc.jpg',
                'remote_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200',
            ],
        ];

        foreach ($galleryData as $item) {
            $event  = $events->firstWhere('title', $item['event_title']) ?? $events->random();
            $member = $members->random();

            $gallery = Gallery::create([
                'event_id'    => $event->id,
                'member_id'   => $member->id,
                'caption'     => $item['caption'],
                'is_featured' => $item['is_featured'],
            ]);

            // Attach media
            $attached = false;
            if (!empty($item['local_image'])) {
                $localPath = database_path('seeders/images/' . $item['local_image']);
                if (file_exists($localPath)) {
                    try {
                        $gallery->addMedia($localPath)
                            ->preservingOriginal()
                            ->toMediaCollection('default');
                        $attached = true;
                    } catch (\Throwable $e) {}
                }
            }

            if (!$attached && !empty($item['remote_image'])) {
                try {
                    $gallery->addMediaFromUrl($item['remote_image'])
                        ->toMediaCollection('default');
                } catch (\Throwable $e) {
                    $fallback = database_path('seeders/images/dummy.png');
                    if (file_exists($fallback)) {
                        $gallery->addMedia($fallback)
                            ->preservingOriginal()
                            ->toMediaCollection('default');
                    }
                }
            }
        }

        $this->command->info('6 Foto Galeri Dokumentasi Kegiatan HMIF berhasil dibuat!');
    }
}
