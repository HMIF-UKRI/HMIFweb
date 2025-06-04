<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategories;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categoryIds = EventCategories::pluck('id')->all();

        if (empty($categoryIds)) {
            $this->command->error('No event categories found. Please run the EventCategorySeeder first or ensure categories exist.');

            return;
        }

        $eventsData = [
            [
                'title' => 'Click On Code',
                'slug' => 'click-on-code',
                'description' => 'A coding workshop for beginners.',
                'thumbnail_path' => '/images/kegiatan/coc.jpg',
                'event_date' => Date::create('2023-05-15 10:00:00'),
                'location' => 'SMA 16 Bandung',
                'status' => 'upcoming',
                'event_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sahur On The Road',
                'slug' => 'sotr',
                'description' => 'A community service event during Ramadan.',
                'thumbnail_path' => 'images/kegiatan/sotr.jpg',
                'event_date' => Date::create('2023-05-15 10:00:00'),
                'location' => 'Bandung City',
                'status' => 'upcoming',
                'event_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Diskusi Publik HMIF',
                'slug' => 'diskusi-publik-hmif',
                'description' => 'A public discussion event organized by HMIF.',
                'thumbnail_path' => 'images/kegiatan/diskusi publik.jpg',
                'event_date' => Date::create('2023-05-15 10:00:00'),
                'location' => 'Garasi Cempor',
                'status' => 'upcoming',
                'event_categories_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($eventsData as $data) {
            Event::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['slug'] ?: $data['title'] . '-' . time()),
                'description' => $data['description'],
                'thumbnail_path' => $data['thumbnail_path'],
                'event_date' => Carbon::parse($data['event_date']),
                'location' => $data['location'],
                'status' => $data['status'],
                'event_categories_id' => $categoryIds[array_rand($categoryIds)],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        $this->command->info(count($eventsData) . ' events have been seeded!');
    }
}
