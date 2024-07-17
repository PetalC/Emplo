<?php

namespace Database\Seeders;

use App\Models\School;
use App\Enums\MediaCollections;
use Illuminate\Database\Seeder;

class SchoolResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resourceFolders = [
            'reference-templates',
            'email-templates',
            'contract-templates',
            'advertising-tesources',
            'selection-resources'
        ];

        foreach(School::inRandomOrder()->get() as $school) {
            $this->command->info("Seeding resources for school " . $school->id . "...");

            // Seed 10 files with different resource folders
            for ($i = 1; $i <= 10; $i++) {
                $folder = fake()->randomElement($resourceFolders);
                $this->command->info("Seeding resources " . $i . " with property " . $folder . "...");
                $imagePath = storage_path('seeder/document/test-' . rand(1, 5) . '.png');
                $school->addMedia($imagePath)
                    ->preservingOriginal()
                    ->withCustomProperties(['resourceFolder' => $folder])
                    ->toMediaCollection(MediaCollections::SCHOOL_RESOURCES->value);
            }

            $this->command->info("Seeding user specific resources for school " . $school->id . "...");

            $userfolders = [
                'Compliance',
                'Payroll Documents',
            ];

            for ($i = 1; $i <= 5; $i++) {
                $folder = fake()->randomElement($userfolders);
                $imagePath = storage_path('seeder/document/test-' . rand(1, 5) . '.png');
                $school->addMedia($imagePath)
                    ->preservingOriginal()
                    ->withCustomProperties([
                        'resourceFolder' => $folder,
                        'userID' => 1
                    ])
                    ->toMediaCollection(MediaCollections::USER_RESOURCES->value);
            }

        }


    }
}
