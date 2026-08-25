<?php

namespace Database\Seeders;

use App\Models\PeriodeKepengurusan;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        $cabinets = [
            [
                'cabinet_name' => 'MetaForsa',
                'period_range' => '2025-2026',
                'vision' => 'Mewujudkan Himpunan Mahasiswa Informatika (HMIF) UKRI sebagai organisasi yang progresif, adaptif terhadap inovasi teknologi, serta wadah kolaboratif yang inklusif dalam mencetak insan akademis yang berdaya saing global.',
                'mission' => "1. Mengembangkan budaya riset, teknologi, dan eksplorasi karya digital di kalangan mahasiswa informatika.\n2. Meningkatkan kapasitas kepemimpinan, integritas, dan solidaritas kader HMIF UKRI melalui pembinaan berkelanjutan.\n3. Membangun sinergi kemitraan strategis dengan industri teknologi, instansi profesional, akademisi, serta jejaring alumni.\n4. Mewujudkan tata kelola organisasi yang transparan, profesional, akuntabel, dan berbasis pemanfaatan teknologi informasi.",
                'start_date' => '2025-01-01',
                'end_date' => '2026-12-31',
                'is_current' => true,
            ],
            [
                'cabinet_name' => 'Digiswara',
                'period_range' => '2024',
                'vision' => 'Menjadikan HMIF UKRI sebagai episentrum pergerakan digital mahasiswa yang berintegritas, mandiri, dan berkarakter kebangsaan.',
                'mission' => "1. Memperkuat fondasi keilmuan informatika dan literasi digital mahasiswa di era transformasi 4.0.\n2. Menghadirkan program kerja kreatif yang berdampak nyata bagi almamater UKRI dan masyarakat luas.\n3. Mendorong pencapaian prestasi akademik dan kompetisi teknologi mahasiswa di tingkat regional maupun nasional.",
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'is_current' => false,
            ],
            [
                'cabinet_name' => 'Raksabhinaya',
                'period_range' => '2023',
                'vision' => 'Membangun HMIF UKRI yang solid, responsif, dan unggul dalam karya serta pengabdian berbasis teknologi informasi.',
                'mission' => "1. Menciptakan iklim kekeluargaan yang erat, harmonis, dan menjunjung tinggi sportivitas di antara mahasiswa informatika.\n2. Menumbuhkan semangat inovasi, eksplorasi riset, dan daya cipta karya teknologi mahasiswa.\n3. Menjalin komunikasi yang aktif, solutif, dan harmonis di lingkungan internal maupun eksternal kampus.",
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'is_current' => false,
            ],
        ];

        foreach ($cabinets as $cabinet) {
            PeriodeKepengurusan::updateOrCreate(
                ['cabinet_name' => $cabinet['cabinet_name']],
                [
                    'period_range' => $cabinet['period_range'],
                    'vision'       => $cabinet['vision'],
                    'mission'      => $cabinet['mission'],
                    'start_date'   => $cabinet['start_date'],
                    'end_date'     => $cabinet['end_date'],
                    'is_current'   => $cabinet['is_current'],
                ]
            );
        }
    }
}

