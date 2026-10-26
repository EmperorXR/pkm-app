<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question_text' => fake()->sentence(10).'?',
            'option_a' => fake()->sentence(5),
            'option_b' => fake()->sentence(5),
            'option_c' => fake()->sentence(5),
            'option_d' => fake()->sentence(5),
            'correct_answer' => fake()->randomElement(['A', 'B', 'C', 'D']),
            'explanation' => fake()->paragraph(),
            'order_number' => fake()->numberBetween(1, 10),
        ];
    }
}
