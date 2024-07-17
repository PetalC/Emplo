<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Referee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school' => $this->faker->company,
            'degree' => $this->faker->jobTitle,
            'story' =>  fake( 'en_au' )->paragraph,
            'ended_at' => $this->faker->dateTime,
            'started_at' => $this->faker->dateTime,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
