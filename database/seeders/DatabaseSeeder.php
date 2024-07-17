<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only seed if not prod.
        if (!App::environment('prod')) {
            $this->call(
                [
                    TaxonomySeeder::class,
                    PlanSeeder::class,
                    SubjectMappingSeeder::class,
                    RoleSeeder::class,
                    SchoolSeeder::class,
                    UserSeeder::class,
                    CampusSeeder::class,
                    JobSeeder::class,
                    ApplicationSeeder::class,
                    CampusFollowersSeeder::class, // This fails if there are not enough users.
                    ApplicationDocumentSeeder::class,
                    ZohoAccessSeeder::class,
                    CountriesTableSeeder::class,
                    StatesTableSeeder::class,
                    CitiesSeeder::class,
                    RefereeSeeder::class,
                    ReferenceCheckSeeder::class
                ]
            );
        }
    }
}
