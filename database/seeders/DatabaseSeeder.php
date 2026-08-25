<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // Roles & Permissions
            MasterDataSeeder::class,     // Dept, Bidang, Angkatan, Categories
            PeriodSeeder::class,         // Periode Kepengurusan
            UserMemberSeeder::class,     // Users, Members, Pengurus & Foto
            EventSeeder::class,          // Event, Registrations, Documents
            BlogSeeder::class,           // Blog & Media Thumbnails
            MerchandiseSeeder::class,    // Merchandise & Media Foto
            PortofolioSeeder::class,     // Portofolio Mahasiswa & Media
            GallerySeeder::class,        // Galeri Foto Dokumentasi Kegiatan
        ]);
    }
}

