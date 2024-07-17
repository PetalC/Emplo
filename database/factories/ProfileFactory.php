<?php

namespace Database\Factories;

use App\Models\CitizenshipType;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProfileFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aussieFaker = \Faker\Factory::create();
        $aussieFaker->addProvider(new \Faker\Provider\en_AU\Address($aussieFaker));
        $aussieFaker->addProvider(new \Faker\Provider\en_AU\PhoneNumber($aussieFaker));
        $maxSalary = rand(50,250)*100;
        // Some date between today and 3 years ago
        $deletedDate = Carbon::today()->subDays(rand(0, 365*3))->addSeconds(rand(0, 86400));

        $rightToWorkOptions = CitizenshipType::pluck('id')->toArray();

        $latitude = fake()->latitude( -44.0, -1.9 );
        $longitude = fake()->longitude( 109, 158 );

        $location = New Point($latitude, $longitude);

        return [
            'address' => $aussieFaker->streetAddress,
            'city' => $aussieFaker->city(),
            'state' => $aussieFaker->state(),
            'country' => 'Australia',
            'zipcode' => $aussieFaker->postcode(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location' => $location,
            'minimum_salary' => $maxSalary - 5000,
            'maximum_salary' => $maxSalary,
            'brief' => fake()->sentence(rand(10, 50)),
            'basic_information' => [],
            'mobile_number' => $aussieFaker->phoneNumber(),
            'alternate_number' => rand(0,1) ? $aussieFaker->phoneNumber() : 123123,
            'years_of_experience' => rand(1, 40),
            'has_accepted_sustainability' => rand(0,1),
            'citizenship_id' => fake()->randomElement($rightToWorkOptions),
            'faith_reference' => rand( 0, 1 ),
            // 10% chance of deleted profile
            'deleted_at' => (rand(0,100) < 10) ? $deletedDate : null,
        ];
    }
}
