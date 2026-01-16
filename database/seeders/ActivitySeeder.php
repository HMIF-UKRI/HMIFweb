<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = Member::first();
        $eCat = EventCategory::first();
        $bCat = BlogCategory::first();

        Event::create([
            'event_category_id' => $eCat->id,
            'title' => 'Workshop Laravel',
            'slug' => 'workshop-laravel',
            'description' => 'Belajar backend',
            'event_date' => now()->addDays(7),
            'status' => 'upcoming'
        ]);

        Blog::create([
            'member_id' => $member->id,
            'id_blog_category' => $bCat->id,
            'title' => 'Tips Coding',
            'slug' => 'tips-coding',
            'status' => 'Published'
        ]);
    }
}
