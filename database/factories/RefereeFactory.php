<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class RefereeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'name' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
            'phone' => fake()->phoneNumber(),
            'position' => fake()->text(50)
        ];
    }
}
