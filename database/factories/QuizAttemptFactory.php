<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    protected $model = QuizAttempt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'quiz_id' => Quiz::factory(),
            'score' => 80.0,
            'correct_count' => 4,
            'total_questions' => 5,
            'is_passed' => true,
            'answers_payload' => ['1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'A'],
            'completed_at' => now(),
        ];
    }
}
