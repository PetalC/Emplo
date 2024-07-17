<?php

namespace Database\Factories;

use App\Enums\JobType;
use App\Enums\SalaryTypes;
use App\Enums\VacancyReasons;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schoolId = rand(1, 10);

        // Some dates in the past 180 days, others in the future 180 days
        $startDate = rand(0, 1) ? Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)) : Carbon::today()->addDays(rand(0, 179))->addSeconds(rand(0, 86400));

        $employment_type = rand( 0, 1 ) ? JobType::FULLTIME->value : JobType::PARTTIME->value;
        return [
            //'school_id' => $schoolId,
            //'campus_id' => 0,
            'uuid' => fake()->uuid(),
            'title' => fake()->jobTitle(),
            'url_slug' => fake()->slug(),
            'description' => fake()->text(3000),
            'responsibilities' => fake()->text(3000),
            'required_licences_certs' => fake()->text(3000),
            'salary_min' => rand(100, 200) * 1000,
            'salary_max' => rand(200, 300) * 1000,
            'salary_type' => rand(0, 1) ? SalaryTypes::SALARY : SalaryTypes::HOURLY,
            'employment_type' => rand(0, 1) ? JobType::FULLTIME : JobType::PARTTIME,
            'start_date' => $startDate,
            'vacancy_reason' => VacancyReasons::OTHER,
        ];
    }
}
