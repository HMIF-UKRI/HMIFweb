<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Bidang;
use App\Models\Departemen;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $years = ['2022', '2023', '2024', '2025'];
        foreach ($years as $year) {
            Angkatan::firstOrCreate(['year' => $year]);
        }

        $departments = [
            'Ring 1' => 'Struktur pimpinan inti',
            'Riset dan Teknologi' => 'Fokus pada pengembangan teknologi dan riset mahasiswa',
            'Pengembangan Sumber Daya Manusia' => 'Fokus pada pemberdayaan anggota',
            'Media dan Komunikasi' => 'Fokus pada branding dan informasi'
        ];

        foreach ($departments as $name => $desc) {
            Departemen::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }

        $mappingBidang = [
            'Riset dan Teknologi' => [
                'Pendidikan',
            ],
            'Pengembangan Sumber Daya Manusia' => [
                'Pelatihan dan Pengembangan',
                'Pengabdian Masyarakat',
                'Minat dan Bakat',
            ],
            'Media dan Komunikasi' => [
                'Humas Internal',
                'Humas Eksternal',
                'Media dan Publikasi',
            ],
        ];

        foreach ($mappingBidang as $deptName => $listBidang) {
            $dept = Departemen::where('name', $deptName)->first();

            if ($dept) {
                foreach ($listBidang as $bName) {
                    Bidang::firstOrCreate([
                        'department_id' => $dept->id,
                        'name'          => $bName,
                    ], [
                        'description'   => 'Fokus pada ' . $bName
                    ]);
                }
            }
        }
    }
}
