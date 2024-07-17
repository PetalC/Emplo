<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\MediaCollections;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\School;
use App\Models\UserProfileCertification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder {

    /**
     * Seed the application's default users.
     */
    public function run(): void {

        /**
         * @var User $schoolAdmin
         */
        $developerAdmin = User::create([
            'first_name' => 'Developer',
            'last_name' => 'Admin',
            'email' => 'admin@developer.com',
            'password' => Hash::make('test1234'),
            'email_verified_at' => now(),
        ]);

        $developerAdmin->assignRole(['Developer']);

        /**
         * @var User $schoolAdmin
         */
        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@super.com',
            'password' => Hash::make('test1234'),
            'email_verified_at' => now(),
        ]);

        // Attach the user to all schools
        $superAdmin->schools()->attach( School::all()->pluck( 'id' ) );
        $superAdmin->assignRole(['School Admin', 'Super Admin']);

        /**
         * @var User $schoolAdmin
         */
        $schoolAdmin = User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'admin@school.com',
            'password' => Hash::make('test1234'),
            'email_verified_at' => now(),
        ]);

        // Attach the user to all schools
        $schoolAdmin->schools()->attach( School::all()->pluck( 'id' ) );
        $schoolAdmin->assignRole('School Admin');

        /**
         * Applicant
         */
        $applicant = User::create( [
            'first_name'        => 'Applicant',
            'last_name'         => 'One',
            'email'             => 'applicant@test.com',
            'password'          => Hash::make( 'test1234' ),
            'email_verified_at' => now(),
        ] );
        $applicant->assignRole( 'Job Seeker' );

        Education::factory( 2 )->create( [
            'user_id' => $applicant->id,
        ] );

        UserProfileCertification::factory( 2 )->create( [
            'user_id' => $applicant->id,
        ] );

        Experience::factory( 2 )->create( [
            'user_id' => $applicant->id,
        ] );

        $profile = Profile::factory( 1 )->create( [
            'user_id' => $applicant->id,
        ] );

        $profile->first()->addMedia( storage_path('seeder' ) . '/images/test-' . rand( 1, 5 ) . '.jpg' )->preservingOriginal()->toMediaCollection( MediaCollections::USER_PROFILE->value );

    }

}
