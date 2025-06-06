<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = EventCategory::pluck('id')->all();

        if (empty($categoryIds)) {
            $this->command->error('No event categories found. Please run the EventCategorySeeder first.');
            return;
        }

        $destinationPath = 'event/thumbnails';

        Storage::disk('public')->deleteDirectory($destinationPath);
        Storage::disk('public')->makeDirectory($destinationPath);

        $eventsData = [
            [
                'title' => 'Click On Code',
                'thumbnail_path' => 'coc.jpg',
                'short_description' => 'A coding workshop for beginners.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
                'event_date' => Date::now(),
                'location' => 'SMA 16 Bandung',
                'status' => 'selesai',
            ],
            [
                'title' => 'Sahur On The Road',
                'thumbnail_path' => 'sotr.jpg',
                'short_description' => 'A community service event during Ramadan.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
                'event_date' => Date::now(),
                'location' => 'Bandung City',
                'status' => 'selesai',
            ],
            [
                'title' => 'Diskusi Publik HMIF',
                'thumbnail_path' => 'diskusi publik.jpg',
                'short_description' => 'A public discussion event organized by HMIF.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet ante turpis. Maecenas sed enim eget magna scelerisque blandit eu in erat. Sed dapibus nisi ex, id faucibus elit varius quis. Nullam quis tempor ipsum, sed ultrices diam. Curabitur a lectus quis arcu pretium imperdiet ut vel ipsum. Suspendisse tincidunt purus sed felis viverra commodo. Donec congue et augue feugiat egestas. Vestibulum mi nulla, finibus vitae viverra imperdiet, ornare a ex. Vestibulum a arcu porta, luctus ipsum sed, hendrerit leo. Vestibulum posuere rutrum nibh, sed consequat purus ultrices in. Vestibulum mi urna, feugiat id aliquam ut, tempor eu risus. Donec nisl ante, ultrices sed sollicitudin sit amet, facilisis a lectus.',
                'event_date' => Date::now(),
                'location' => 'Garasi Cempor',
                'status' => 'selesai',
            ],
        ];

        $dataToInsert = [];

        foreach ($eventsData as $data) {
            $sourceFilePath = database_path('seeders/images/' . $data['thumbnail_path']);

            $newFileName = Str::slug($data['title']) . '.' . pathinfo($data['thumbnail_path'], PATHINFO_EXTENSION);
            $newFilePath = $destinationPath . '/' . $newFileName;

            if (file_exists($sourceFilePath)) {
                Storage::disk('public')->put($newFilePath, file_get_contents($sourceFilePath));
            }

            $dataToInsert[] = [
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'short_description' => $data['short_description'],
                'thumbnail_path' => $newFilePath,
                'event_date' => $data['event_date'],
                'location' => $data['location'],
                'status' => $data['status'],
                'event_category_id' => $categoryIds[array_rand($categoryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Event::insert($dataToInsert);

        $this->command->info(count($dataToInsert) . ' events have been seeded!');
    }
}
