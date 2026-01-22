<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'title'             => $title,
            'slug'              => Str::slug($title),
            'short_description' => fake()->sentence(10),
            'description'       => fake()->paragraphs(3, true),
            'event_date'        => fake()->dateTimeBetween('-1 month', '+3 months'),
            'location'          => fake()->address(),
            'status'            => fake()->randomElement(['upcoming', 'ongoing', 'completed', 'cancelled']),
            'event_category_id' => EventCategory::inRandomOrder()->first()?->id ?? EventCategory::factory(),
        ];
    }

    /**
     * Implementasi Spatie Media Library setelah record dibuat
     */
    public function configure()
    {
        return $this->afterCreating(function (Event $event) {
            $randomId = rand(1, 1000);
            $url = "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800&auto=format&fit=crop&sig={$randomId}";

            try {
                $event->addMediaFromUrl($url)
                    ->toMediaCollection('thumbnails');
            } catch (\Exception $e) {
                logger("Gagal mengunduh gambar untuk Event ID {$event->id}: " . $e->getMessage());
            }
        });
    }
}
