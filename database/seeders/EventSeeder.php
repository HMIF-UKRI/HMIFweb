<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (EventCategory::count() === 0) {
            $this->call(EventCategorySeeder::class);
        }

        $this->command->info('Sedang membuat 10 data event beserta gambarnya...');

        Event::factory()->count(15)->create();

        $this->command->info('10 data event berhasil dibuat!');
    }
}
