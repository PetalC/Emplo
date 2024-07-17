<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Interview;
use App\Models\Job;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach(Application::all() as $application) {

            $this->command->info("Seeding interviews for application ".$application->id."...");

            for ($i = 0; $i < rand(0, 3); $i++) {

                // Load in interview panel members using the job's panel members sometimes
                $panelMembers = [];
                for ($i = 0; $i < rand(0, count($application->job->panel_members)); $i++) {
                    $panelMembers[] = $application->job->panel_members[$i]->id;
                }
                Interview::factory()->create( [
                    'application_id' => $application->id,
                    'panel_members' => $panelMembers
                ] );
            }
        }
    }
}
