<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\Member;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(6);

        $targetPath = public_path('storage/posts/thumbnails');
        if (!File::exists($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
        }

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(10, true),
            'excerpt' => $this->faker->sentence(15),
            'thumbnail_path' => 'posts/thumbnails/' . $this->faker->image($targetPath, 640, 480, null, false),
            'status' => $this->faker->randomElement(['published', 'draft']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'blog_category_id' => BlogCategory::inRandomOrder()->first()->id ?? BlogCategory::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $tags = Tag::inRandomOrder()->limit(3)->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
