<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_periods')->insert([
            [
                'name' => 'Digiswara',
                'start_date' => '2023-01-01',
                'end_date' => '2024-12-31',
                'is_current' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
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
