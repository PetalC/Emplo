<?php

namespace Database\Seeders;

use App\Enums\MediaCollections;
use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationDocumentSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach( Application::all() as $application) {
            $this->command->info("Seeding documents for application ".$application->id."...");

            // 1 in 10 chance of not adding a document
            if( rand( 0, 10 ) != 2 ){
                for ($i = 1; $i < 2; $i++) {
                    $imagePath = storage_path('seeder/document/test-'.$i.'.png');
                    $application->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection(MediaCollections::APPLICATION_DOCUMENTS->value);
                }
            }

        }

    }
}
