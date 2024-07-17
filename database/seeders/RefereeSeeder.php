<?php

namespace Database\Seeders;


use App\Models\Referee;
use Illuminate\Database\Seeder;

class RefereeSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        Referee::factory()->count(2 )->create();
    }

}
