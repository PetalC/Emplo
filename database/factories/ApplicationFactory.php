<?php

namespace Database\Factories;

use App\Enums\ApplicationStatuses;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Uid\Ulid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Some dates in the past 180 days, others in the future 180 days
        $shortlisted_at =  rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));
        $declined_at =  rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));
        $created_at =  rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));
        return [
//            'id' => $this->faker->unique()->id(),
            'ulid' => Ulid::generate( now() ),
            'specialities' => [
                fake()->jobTitle()
            ],
            'registration' => [],
            'right_to_work' => rand(0,1),
            'current_occupation' => fake()->jobTitle,
            'job_type' => fake()->jobTitle(),
            'referred_method' => fake()->domainName(),
            // 50% draft 50% other status
            'status' => rand(0,1) ? ApplicationStatuses::STATUS_SUBMITTED : $this->faker->randomElement( [ ApplicationStatuses::STATUS_SHORTLISTED, ApplicationStatuses::STATUS_DECLINED, ApplicationStatuses::STATUS_HIRED ] ),
            // 20% chance of shortlisted
            'shortlisted_at' => (rand(0,100) < 20) ? $shortlisted_at : null,
            // 5% chance of declined
            'declined_at' => (rand(0,100) < 5) ? $declined_at : null,
            'created_at' => $created_at,
        ];
    }
}
