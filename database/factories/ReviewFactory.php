<?php

namespace Database\Factories;

use App\Enums\ApplicationReviewStatuses;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = array_column(ApplicationReviewStatuses::cases(), 'value');

        // Some dates in the past 180 days, others in the future 180 days
        $startDate = rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));
        return [
            'status' => $statuses[array_rand($statuses)],
            'created_at' => $startDate
        ];
    }
}
