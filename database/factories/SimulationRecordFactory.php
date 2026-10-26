<?php

namespace Database\Factories;

use App\Models\SimulationRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SimulationRecord>
 */
class SimulationRecordFactory extends Factory
{
    protected $model = SimulationRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'simulation_type' => 'spk_saw',
            'title' => fake()->sentence(4),
            'input_data' => ['criteria' => [], 'alternatives' => []],
            'result_data' => ['ranking' => []],
        ];
    }
}
