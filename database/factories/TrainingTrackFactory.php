<?php

namespace Database\Factories;

use App\Models\TrainingTrack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TrainingTrack>
 */
class TrainingTrackFactory extends Factory
{
    protected $model = TrainingTrack::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'icon' => 'sparkles',
            'level' => 'Pemula - Menengah',
            'duration_hours' => fake()->numberBetween(10, 30),
            'instructor_name' => fake()->name(),
            'instructor_title' => 'Dosen & Praktisi AI',
            'is_active' => true,
        ];
    }
}
