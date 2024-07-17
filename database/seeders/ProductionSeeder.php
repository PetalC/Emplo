<?php

namespace Database\Seeders;

use App\Enums\MediaCollections;
use App\Models\Application;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Populate data required for production
 */
class ProductionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call( [
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesSeeder::class,
            SubjectMappingSeeder::class,
            RoleSeeder::class,
            TaxonomySeeder::class
        ] );

        /**
         * @var User $user
         */
        $users = [];

        $users[] = User::create( [
            'first_name' => 'Ben',
            'last_name' => 'Casey',
            'email' => 'ben.casey@humanpixel.com.au',
            'password' => Hash::make('hfz1t@T5J9CHz1'),
            'email_verified_at' => now()
        ] );

        $users[] = User::create( [
            'first_name' => 'Tyson',
            'last_name' => 'Wood',
            'email' => 'tyson.wood@the-schoolhouse.com.au',
            'password' => Hash::make('hfz1t@T5J9CHz1'),
            'email_verified_at' => now()
        ] );

        $users[] = User::create( [
            'first_name' => 'Justin',
            'last_name' => 'Windle',
            'email' => 'justin.windle@humanpixel.com.au',
            'password' => Hash::make('hfz1t@T5J9CHz1'),
            'email_verified_at' => now()
        ] );

        foreach( $users as $user ){
            $user->assignRole('School Admin' );
            $user->schools()->sync( School::whereIn( 'name', [ 'Demonstration College', 'Test School Australia' ] )->pluck( 'id' ) );
        }

        $job_seekers = [];

        /**
         * @var User $user
         */
        $job_seekers[] = User::create( [
            'first_name' => 'Ben',
            'last_name' => 'Casey',
            'email' => 'ben.casey+applicant@humanpixel.com.au',
            'password' => Hash::make('hfz1t@T5J9CHz1')
        ] );

        foreach( $job_seekers as $user ){
            $user->assignRole('Job Seeker' );
        }

        $this->command->info('Created users.');

    }
}
