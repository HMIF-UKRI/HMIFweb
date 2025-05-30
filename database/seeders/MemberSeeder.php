<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'name' => 'Chriss Hendry Choong',
                'student_id_number' => '20221310011',
                'image' => '/images/pengurus/acong.png',
                'position' => 'Ketua Himpunan',
                'organization_periods_id' => 1,
                'departments_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muhammad Ikhsan Kamil',
                'student_id_number' => '20221310012',
                'image' => '/images/pengurus/ikhsan.png',
                'position' => 'Wakil Ketua Himpunan',
                'organization_periods_id' => 1,
                'departments_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tania Cahyani Putri',
                'student_id_number' => '20221310013',
                'image' => '/images/pengurus/tania.png',
                'position' => 'Sekretaris',
                'organization_periods_id' => 1,
                'departments_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
