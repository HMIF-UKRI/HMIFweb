<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;

use App\Models\PeriodeKepengurusan;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        PeriodeKepengurusan::create([
            'cabinet_name' => 'Kabinet Sinergi',
            'period_range' => '2025-2026',
            'vision' => 'Visi Organisasi',
            'mission' => 'Misi Organisasi',
            'cabinet_logo' => 'default.png',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'is_current' => true,
        ]);
    }
}
