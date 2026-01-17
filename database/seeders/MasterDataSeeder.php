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
        $years = ['2022', '2023', '2024', '2025'];
        foreach ($years as $year) {
            Angkatan::firstOrCreate(['year' => $year]);
        }

        $departments = [
            'Ring 1',
            'Riset dan Teknologi',
            'Pengembangan Sumber Daya Manusia',
            'Media dan Komunikasi'
        ];

        foreach ($departments as $name) {
            Departemen::firstOrCreate([
                'name' => $name,
                'description' => 'Departemen ' . $name
            ]);
        }

        $bidangList = [
            'Bidang Pendidikan',
            'Bidang Pelatihan dan Pengembangan',
            'Bidang Pengabdian Masyarakat',
            'Bidang Minat dan Bakat'
        ];

        $ristek = Departemen::where('name', 'Riset dan Teknologi')->first();

        foreach ($bidangList as $bName) {
            Bidang::firstOrCreate([
                'department_id' => $ristek->id,
                'name' => $bName,
                'description' => 'Fokus pada ' . $bName
            ]);
        }
    }
}
