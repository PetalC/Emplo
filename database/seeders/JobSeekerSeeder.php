<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JobSeekerSeeder extends Seeder
{

    const TEST_DOMAIN = 'laravel-app.jobseeker.test.domain.com';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Clear test jobseekers
        DB::table(app(User::class)->getTable())->where('email', 'like', '%'.self::TEST_DOMAIN)->delete();

        // Get the jobseeker role
        $jobseekerRole = Role::where('name', 'job seeker')->first();

        foreach (School::all() as $school) {
            // Create jobseekers for each school
            for ($i = 1; $i < rand(10, 50); $i++) {
                // Create user
                $user = User::create([
                    'first_name' => 'Jobseeker',
                    'last_name' => 'Number ' . $i + 1, // To make each last name unique
                    'email' => ($i + 1) . '@'.self::TEST_DOMAIN,
                    'password' => Hash::make('password'),
                ]);

                // Attach user to the school
                $user->schools()->attach($school->id);

                // Attach jobseeker role to the user
                $user->roles()->attach($jobseekerRole);
            }

        }
    }
}
