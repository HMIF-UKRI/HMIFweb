<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_periods')->insert([
            [
                'id' => 1,
                'name' => 'MetaForsa',
                'start_date' => '2025-01-01',
                'end_date' => '2026-12-31',
                'is_current' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Digiswara',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Raksabhinaya',
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
