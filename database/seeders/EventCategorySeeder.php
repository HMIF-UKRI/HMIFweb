<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Seminar',
            'Workshop',
            'Kompetisi',
            'Talkshow',
            'Pengabdian Masyarakat',
            'Pelatihan',
        ];

        foreach ($categories as $categoryName) {
            EventCategory::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );
        }

        $this->command->info('Event categories have been seeded!');
    }
}
