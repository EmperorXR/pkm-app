<?php

namespace Database\Factories;

use App\Models\TrainingModule;
use App\Models\TrainingTrack;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TrainingModule>
 */
class TrainingModuleFactory extends Factory
{
    protected $model = TrainingModule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'training_track_id' => TrainingTrack::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => fake()->paragraph(),
            'content' => '<p>'.fake()->paragraph(3).'</p>',
            'key_takeaways' => [fake()->sentence(), fake()->sentence()],
            'duration_minutes' => fake()->numberBetween(30, 90),
            'order_number' => fake()->numberBetween(1, 10),
            'resource_type' => 'article',
            'resource_url' => fake()->url(),
        ];
    }
}
