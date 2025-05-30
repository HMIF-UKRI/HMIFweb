<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Click On Code',
                'slug' => 'click-on-code',
                'description' => 'A coding workshop for beginners.',
                'thumbnail_path' => 'storage/images/events/click-on-code.jpg',
                'event_date' => Date::create('2023-05-15 10:00:00'),
                'location' => 'SMA 16 Bandung',
                'status' => 'upcoming',
                'event_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
