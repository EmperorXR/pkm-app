<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Certificate>
 */
class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'certificate_number' => 'CERT/'.date('Y').'/'.strtoupper(Str::random(6)),
            'verify_code' => 'VRF-'.strtoupper(Str::random(8)),
            'user_id' => User::factory(),
            'training_track_id' => TrainingTrack::factory(),
            'quiz_attempt_id' => null,
            'final_score' => 85.0,
            'issue_date' => now()->toDateString(),
            'status' => 'valid',
        ];
    }
}
