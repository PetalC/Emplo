<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Plan;
use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::factory()->count(2 )->create();

        foreach( $schools as $school ){
            $school->subscribeTo( Plan::query()->inRandomOrder()->first() );
        }

    }
}
