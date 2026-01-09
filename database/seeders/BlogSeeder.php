<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Post::truncate();
        BlogCategory::truncate();
        Tag::truncate();
        DB::table('post_tag')->truncate();

        $this->command->info('Truncating blog tables completed.');

        BlogCategory::factory(5)->create();
        $this->command->info('Blog categories created.');

        Tag::factory(10)->create();
        $this->command->info('Tags created.');

        if (User::count() > 0) {
            Post::factory(20)->create();
            $this->command->info('Posts with tags created.');
        } else {
            $this->command->warn('Skipping post creation because no users found.');
        }

        Schema::enableForeignKeyConstraints();
    }
}
