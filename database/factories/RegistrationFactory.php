<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

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
            'registration_code' => 'REG-'.strtoupper(Str::random(8)),
            'status' => 'approved',
            'registered_at' => now(),
            'attended' => false,
            'motivation_reason' => fake()->sentence(),
            'prior_experience' => 'Pemula (Dasar)',
        ];
    }
}
