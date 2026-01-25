<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\PeriodeKepengurusan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Takrifkan keadaan asal model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(fake()->numberBetween(4, 8));

        return [
            'title'             => $title,
            'slug'              => Str::slug($title) . '-' . rand(100, 999),
            'short_description' => fake()->paragraph(1),
            'description'       => $this->generateEditorJsJson(),
            'event_date'        => fake()->dateTimeBetween('-1 month', '+5 months'),
            'location'          => fake()->randomElement(['Auditorium UKRI', 'Ruang Multimedia', 'Basecamp HMIF', 'Gedung Serbaguna']),
            'status'            => fake()->randomElement(['upcoming', 'ongoing', 'completed', 'cancelled']),

            'event_category_id' => EventCategory::inRandomOrder()->first()?->id ?? EventCategory::factory(),
            'period_id'         => PeriodeKepengurusan::inRandomOrder()->first()?->id ?? PeriodeKepengurusan::factory(),
            'member_id'         => Member::inRandomOrder()->first()?->id ?? Member::factory(),
        ];
    }

    /**
     * Menjana struktur data JSON palsu yang serasi dengan Editor.js
     */
    private function generateEditorJsJson(): string
    {
        $blocks = [
            [
                'type' => 'header',
                'data' => [
                    'text' => 'Butiran Acara Utama',
                    'level' => 2
                ]
            ],
            [
                'type' => 'paragraph',
                'data' => [
                    'text' => fake()->paragraph(3)
                ]
            ],
            [
                'type' => 'quote',
                'data' => [
                    'text' => fake()->sentence(10),
                    'caption' => 'Penganjur Acara',
                    'alignment' => 'left'
                ]
            ],
            [
                'type' => 'list',
                'data' => [
                    'style' => 'unordered',
                    'items' => [
                        fake()->sentence(5),
                        fake()->sentence(5),
                        fake()->sentence(5),
                    ]
                ]
            ]
        ];

        return json_encode(['blocks' => $blocks]);
    }

    /**
     * Konfigurasi factory untuk mengendalikan Spatie Media Library
     */
    public function configure()
    {
        return $this->afterCreating(function (Event $event) {
            $randomId = rand(1, 500);
            $url = "https://picsum.photos/id/{$randomId}/1200/800";

            try {
                $event->addMediaFromUrl($url)
                    ->toMediaCollection('thumbnails');
            } catch (\Exception $e) {
                logger("Gagal memuat turun imej untuk Event ID {$event->id}: " . $e->getMessage());
            }
        });
    }
}
