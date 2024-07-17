<?php

namespace Database\Factories;

use Faker\Generator;
use Faker\Provider\en_AU\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campus>
 */
class CampusProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * /**
     *  array:4 [▼
     *  "north" => -44.044519440535
     *  "east" => 158.00584212775
     *  "south" => -1.9341887290883
     *  "west" => 109.36707836541
     *  ]
     *
     * /
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

//        $faker = new Generator();
//        fake( 'en_au' );

        $latitude = fake()->latitude( -44.0, -1.9 );
        $longitude = fake()->longitude( 109, 158 );

        $location = New Point($latitude, $longitude);

        return [
            'campus_id' => 0,
            'is_active' => false,
            'name' => fake( 'en_au' )->company,
            'description' => '<p>' . join( '</p><p>', fake( 'en_au' )->paragraphs( rand( 1, 3 ) ) ) . '</p>',
            'address' => fake( 'en_au' )->streetAddress,
            'city' => fake( 'en_au' )->city,
            'state' => fake( 'en_au' )->state,
            'country' => 'Australia',
            'zipcode' => fake( 'en_au' )->postcode,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location' => $location,
            'proposition' => '<p>' . join( '</p><p>', fake( 'en_au' )->paragraphs( rand( 1, 3 ) ) ) . '</p>',
            'youtube_embed_url' => 'https://www.youtube.com/embed/fslL-sjPr5g?si=wGYwdr49eWbWBLwL',
            'video_url' => 'https://www.youtube.com/embed/fslL-sjPr5g?si=wGYwdr49eWbWBLwL',
            'student_enrollments' => rand(0, 1000),
            'staff_size' => rand(500, 1000),
            'teacher_size' => rand(30, 300),
            'quote' => fake()->sentence( 20 ),
            'branding_primary_color' => fake()->hexColor(),
            'branding_secondary_color' => fake()->hexColor(),
            'branding_tertiary_color' => fake()->hexColor(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'deleted_at' => null,
        ];
    }
}
