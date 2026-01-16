<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\BlogCategory;
use App\Models\Departemen;
use App\Models\EventCategory;
use App\Models\PortofolioCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Angkatan
        Angkatan::create(['year' => '2023']);
        Angkatan::create(['year' => '2024']);

        // Departemen & Bidang
        $saintek = Departemen::create([
            'name' => 'Sains dan Teknologi', //
            'description' => 'Departemen pengembangan riset teknologi' //
        ]);

        Bidang::create([
            'department_id' => $saintek->id, //
            'name' => 'Bidang Pendidikan', //
            'description' => 'Fokus pada edukasi internal' //
        ]);

        EventCategory::create(['name' => 'Seminar', 'slug' => 'seminar']); //
        BlogCategory::create(['name' => 'Opini', 'slug' => 'opini']); //
        PortofolioCategory::create(['name' => 'Web Development', 'description' => 'Proyek berbasis web']); //
    }
}
