<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\TrainingTrack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'training_track_id' => TrainingTrack::factory(),
            'training_module_id' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'time_limit_minutes' => 20,
            'passing_score' => 70,
            'is_active' => true,
        ];
    }
}
