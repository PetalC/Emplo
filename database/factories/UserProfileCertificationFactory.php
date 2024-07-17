<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\LicencingAuthorityTypes;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class UserProfileCertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $enumValues = array_column(LicencingAuthorityTypes::cases(), 'value');

        return [
            'institution' => $this->faker->company,
            'certification' => $this->faker->randomElement($enumValues),
            'description' => fake( 'en_au' )->paragraph,
            'completed_at' => $this->faker->dateTime,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
