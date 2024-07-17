<?php

namespace Database\Seeders;

use App\Enums\ApplicationReferenceCheckStatuses;
use App\Models\Application;
use App\Models\Referee;
use App\Models\ReferenceCheck;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReferenceCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Application::inRandomOrder()->get() as $application) {

            $this->command->info("Seeding reference checks for application ".$application->id."...");

            $status = (rand(0,100) > 80) ? ApplicationReferenceCheckStatuses::COMPLETED : ApplicationReferenceCheckStatuses::INTRO;

            $application->update([
                'references_requested_at' => (rand(0,100) > 90) ? Carbon::now()->subDays(rand(0,180)) : null
            ]);

            // create applicants
            for ($i = 0; $i < 2; $i++) {
                $referenceCheckData = [
                    'application_id' => $application->id,
                    'candidate_id' => $application->user->id,
                    'referee_id' => Referee::inRandomOrder()->first()->id,
                    'status' => $status,
                ];
                $referenceCheckDummyResponseData = [];
                // 50% have dummy reference check responses
                if (rand(0,1)) {
                    $referenceCheckDummyResponseData = [
                        'child_protection_details' => fake()->text(50),
                        'performance_related_details' => fake()->text(50),
                        'reason_not_with_children_details' => fake()->text(50),
                        'recent_child_protection' => rand(0,3),
                        // TODO: redesign storage pattern - recommended (bool) recommended reason (string)
//                        'recommended_yes_details' => fake()->text(50),
//                        'recommended_no_details' => fake()->text(50),
                        // TODO: redesign storage pattern - rehire (bool) rehire reason (string)
//                        'rehire_yes_details' => fake()->text(50),
//                        'rehire_no_details' => fake()->text(50),
                    ];
                }
                // 50% no ratings
                $referenceCheckRatings = rand(0,1) ? [] : [
                    'know_student' => rand(0,3),
                    'know_content' => rand(0,3),
                    'plan_for_teaching' => rand(0,3),
                    'create_learning' => rand(0,3),
                    'assess_learning' => rand(0,3),
                    'professionalism' => rand(0,3),
                    'colleague_engagement' => rand(0,3),
                ];
                $referenceCheckData = array_merge(
                    $referenceCheckData,
                    $referenceCheckDummyResponseData,
                    $referenceCheckRatings
                );
                ReferenceCheck::factory()->create($referenceCheckData);
            }
        }
    }
}
