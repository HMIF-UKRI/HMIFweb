<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'npm' => fake()->unique()->numerify('##########'),
            'is_active' => true,
            'instagram_url' => 'https://instagram.com/' . fake()->userName(),
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Member $member) {
            $url = 'https://picsum.photos/400/400';

            $member->addMediaFromUrl($url)
                ->toMediaCollection('avatars');
        });
    }
}
