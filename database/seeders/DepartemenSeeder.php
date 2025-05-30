<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departemens')->insert([
            ['name' => 'Ring 1'],
            ['name' => 'Riset dan Teknologi'],
            ['name' => 'Pengembangan Sumber Daya Manusia'],
            ['name' => 'Media dan Komunikasi'],
        ]);
    }
}
