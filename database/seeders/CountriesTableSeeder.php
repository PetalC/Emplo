<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Australia',
                'iso3' => 'AUS',
                'iso2' => 'AU',
                'phonecode' => '+61',
                'capital' => 'Canberra',
                'currency' => 'AUD',
                'region' => 'Oceania',
                'subregion' => 'Australia and New Zealand',
                'emoji' => '🇦🇺',
            ],
            // Add more country data as needed
        ];

        // Insert the country data into the database
        DB::table('countries')->insert($countries);
    }
}
