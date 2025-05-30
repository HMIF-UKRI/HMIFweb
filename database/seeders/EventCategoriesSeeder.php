<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_categories')->insert([
            [
                'name' => 'Sosial',
                'slug' => 'sosial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seminar',
                'slug' => 'seminar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Workshop',
                'slug' => 'workshop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
