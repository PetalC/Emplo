<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $australianCities = [
            ['name' => 'Sydney', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 1],
            ['name' => 'Melbourne', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 2],
            ['name' => 'Brisbane', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 3],
            ['name' => 'Perth', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 5],
            ['name' => 'Adelaide', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 4],
            ['name' => 'Gold Coast', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 3],
            ['name' => 'Newcastle', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 1],
            ['name' => 'Canberra', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 8],
            ['name' => 'Sunshine Coast', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 3],
            ['name' => 'Wollongong', 'country_id' => 1, 'country_code' => 'AU', 'state_id' => 1],
            ['name' => 'Cairns', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Townsville', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Toowoomba', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Mackay', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Rockhampton', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Bundaberg', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Hervey Bay', 'state_id' => 3, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Central Coast', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Port Macquarie', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Coffs Harbour', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Tamworth', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Orange', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Dubbo', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Bathurst', 'state_id' => 1, 'country_id' => 1, 'country_code' => 'AU']
        ];

        foreach ($australianCities as $cityData) {
            City::create($cityData);
        }

    }
}
