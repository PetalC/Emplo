<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class CampusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $school = School::all()->random()->first();

        return [
            'uuid' => Str::uuid(),
            'school_id' => $school->id,
            'uuid' => Str::uuid(),
            'url_slug' => fake()->unique()->slug,
        ];
    }
}
