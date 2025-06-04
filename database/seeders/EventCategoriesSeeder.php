<?php

namespace Database\Seeders;

use App\Models\EventCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategoriesSeeder extends Seeder
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
            EventCategories::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );
        }

        $this->command->info('Event categories have been seeded!');
    }
}
