<?php

namespace App\Models;

use Database\Factories\SimulationRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimulationRecord extends Model
{
    /** @use HasFactory<SimulationRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'simulation_type',
        'title',
        'input_data',
        'result_data',
    ];

    protected function casts(): array
    {
        return [
            'input_data' => 'array',
            'result_data' => 'array',
        ];
    }

    /**
     * Get user who performed the simulation.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
