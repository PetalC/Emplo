<?php

namespace Database\Seeders;

use App\Enums\JobStatus;
use App\Models\Application;
use App\Models\Job;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\MediaCollections;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {

        foreach(School::all() as $school) {

            $this->command->info("Seeding jobs for school ".$school->id."...");

            for ($i = 0; $i < 2; $i++) {
//            for ($i = 0; $i < rand(2, 10); $i++) {

                $campus_id = $school->campuses()->exists() ? ( $school->campuses->random() )->id : false;

                $job = Job::factory()->create( [
                    'school_id' => $school->id,
                    'campus_id' => $campus_id,
                    'status' => rand( 0, 1 ) ? JobStatus::DRAFT : JobStatus::OPEN,
                ] );

                $this->command->info("Seeding supporting documents for job ".$job->id."...");
                $job->addMedia(storage_path('seeder/document/test-' . $i + 1 . '.png'))
                        ->preservingOriginal()
                        ->toMediaCollection(MediaCollections::JOBCENTRE_JOB_DOCUMENTS->value);
            }

        }

    }

}
