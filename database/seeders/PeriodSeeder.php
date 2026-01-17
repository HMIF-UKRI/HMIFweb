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
                'id' => 1,
                'cabinet_name' => 'MetaForsa',
                'period_range' => '2025-2026',
                'start_date' => '2025-01-01',
                'end_date' => '2026-12-31',
                'is_current' => true,
            ],
            [
                'id' => 2,
                'cabinet_name' => 'Digiswara',
                'period_range' => '2025',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
            ],
            [
                'id' => 3,
                'cabinet_name' => 'Raksabhinaya',
                'period_range' => '2024-2025',
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
            ],
        ];

        foreach ($cabinets as $cabinet) {
            PeriodeKepengurusan::create([
                'cabinet_name' => $cabinet['cabinet_name'],
                'period_range' => $cabinet['period_range'],
                'vision' => 'Visi Organisasi',
                'mission' => 'Misi Organisasi',
                'start_date' => $cabinet['start_date'],
                'end_date' => $cabinet['end_date'],
                'is_current' => $cabinet['is_current'],
            ]);
        }
    }
}
