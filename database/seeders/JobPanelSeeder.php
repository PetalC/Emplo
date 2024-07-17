<?php

namespace Database\Seeders;

use App\Models\JobPanel;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Seeder;
class JobPanelSeeder extends Seeder
{
    public function run()
    {

        // add random users to some jobs
        foreach (Job::all()->take(10) as $job) {
            $panelMemberAmount = rand(1,3);
            $this->command->info('Seeding '.$panelMemberAmount.' panel members for job '.$job->id.'...');
            foreach (User::all()->take($panelMemberAmount) as $user) {
                JobPanel::create([
                    'job_id' => $job->id,
                    'user_id' => $user->id
                ]);
            }
        }

    }
}
