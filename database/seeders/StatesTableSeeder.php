<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $states = [
            ['name' => 'New South Wales', 'iso2' => 'NSW', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Victoria', 'iso2' => 'VIC', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Queensland', 'iso2' => 'QLD', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'South Australia', 'iso2' => 'SA', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Western Australia', 'iso2' => 'WA', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Tasmania', 'iso2' => 'TAS', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Northern Territory', 'iso2' => 'NT', 'country_id' => 1, 'country_code' => 'AU'],
            ['name' => 'Australian Capital Territory', 'iso2' => 'ACT', 'country_id' => 1, 'country_code' => 'AU'],
        ];

        // Insert the state data into the database
        DB::table('states')->insert($states);

        Artisan::call( 'emplo:process-au-geodata' );// Process the AU geodata data set for states

    }
}
