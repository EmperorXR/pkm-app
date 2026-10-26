<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discussion>
 */
class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'training_track_id' => TrainingTrack::factory(),
            'title' => fake()->sentence(6),
            'content' => fake()->paragraph(3),
            'category' => 'Umum',
            'is_resolved' => false,
            'views_count' => fake()->numberBetween(0, 100),
        ];
    }
}
