<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\Profile;
use App\Models\School;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApplicationSeeder extends Seeder
{

    const TEST_DOMAIN = 'laravel-app.seeder.test.domain.com';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table(app(User::class)->getTable())->where('email', 'like', '%'.self::TEST_DOMAIN)->delete();

        foreach(Job::all() as $job) {

            $this->command->info("Seeding applications for job ".$job->id."...");
            // create applicants
            for ($i = 0; $i < 2; $i++) {
//            for ($i = 0; $i < rand(2, 10); $i++) {

                $user = User::factory()->make([
                    'email' => 'applicants'.$i.'job'.$job->id.'@'.self::TEST_DOMAIN,
                    'disabled' => rand(0,1),
                ]);
                $user->assignRole( 'Job Seeker' );
                $user->save();

                $this->command->info("Seeding applicants profile for user ".$user->id."...");
                $user->profile()->save(Profile::factory()->make());

                $job->applications()->save( Application::factory()->make( [
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                    'campus_id' => $job->campus->id,
                    'specialities' => Subject::all()->random(3)->pluck('name', 'id' )->toArray(),
                ] ) );

            }

        }

    }
}
