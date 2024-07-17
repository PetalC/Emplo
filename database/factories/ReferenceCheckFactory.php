<?php

namespace Database\Factories;

use App\Enums\ApplicationReferenceCheckStatuses;
use App\Models\Application;
use App\Models\Job;
use App\Models\Referee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class ReferenceCheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Some dates in the past 180 days
        $startDate = Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400));
        // up to 4 years after the start date
        $endDate = $startDate->addDays(rand(0, 4*365));
        return [
            'ulid' => Ulid::generate( now() ),
            'application_id' => Application::inRandomOrder()->first()->id,
            'referee_id' => Referee::inRandomOrder()->first()->id,
            'candidate_id' => User::inRandomOrder()->first()->id,
            'status' => ApplicationReferenceCheckStatuses::INTRO,
            'comment' => fake()->text(50),
            'position' => fake()->jobTitle,
            'place_of_emplo' => fake()->city.' School',
            'work_with_date_start' => $startDate,
            'work_with_date_end' => $endDate
        ];
    }
}
