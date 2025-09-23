<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\Member;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(10, true),
            'excerpt' => $this->faker->sentence(15),
            'thumbnail_path' => 'posts/thumbnails/' . $this->faker->image('public/storage/posts/thumbnails', 640, 480, null, false),
            'status' => $this->faker->randomElement(['published', 'draft']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'author_id' => Member::inRandomOrder()->first()->id ?? null,
            'blog_category_id' => BlogCategory::inRandomOrder()->first()->id ?? null,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Ambil 3 tag acak dari database
            $tags = Tag::inRandomOrder()->limit(3)->get();

            // Lampirkan (attach) tag-tag tersebut ke post yang baru dibuat
            $post->tags()->attach($tags);
        });
    }
}
