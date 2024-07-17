<?php

namespace Database\Factories;

use App\Enums\InterviewType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InterviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $types = array_column(InterviewType::cases(), 'value');

        // Some dates in the past 180 days, others in the future 180 days
        $scheduledDate = rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));
        return [
            'application_id' => 0,
            'type' => $types[array_rand($types)],
            'notes' => fake()->text(rand(50, 3000)),
            'scheduled_at' => $scheduledDate
        ];
    }
}
