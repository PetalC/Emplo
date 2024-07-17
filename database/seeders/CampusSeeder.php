<?php

namespace Database\Seeders;

use App\Enums\MediaCollections;
use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\Curriculum;
use App\Models\LocationType;
use App\Models\Religion;
use App\Models\School;
use App\Models\SchoolGender;
use App\Models\SchoolType;
use App\Models\Sector;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {

//        dd(

//        dd( storage_path('seeder' ) . '/images/test-' . rand( 1, 5 ) . '.jpg' );

        $schools = School::all();

        $images = [];

//        foreach( range( 0, 2 ) as $i ){
//            $images[] = file_get_contents( 'https://picsum.photos/1200/800' );
//        }

        foreach( $schools as $school ) {

            $this->command->info( 'Seeding campuses for school ' . $school->id );

            $campuses = Campus::factory()->count(2 )->create();
            foreach ($campuses as $campus) {
                $campus->update(['school_id' => $school->id]);

                //Create a campus profile for each campus
                CampusProfile::factory( 1 )->create( [
                    'campus_id' => $campus->id,
                    'name' => $school->name,
                ] )->each( function ( CampusProfile $campusProfile ) use ( $campus, $images ){

                    $this->command->info( 'Creating campus profile for ' . $campus->id );

                    if( CampusProfile::query()
                        ->where( 'campus_id', '=', $campus->id )
                        ->where( 'is_active', '=', true )->doesntExist()
                    ){
                        $campusProfile->is_active = true;
                        $campusProfile->save();
                    }

                    $campusProfile->addMedia( storage_path('seeder' ) . '/images/test-' . rand( 1, 5 ) . '.jpg' )->preservingOriginal()->toMediaCollection( MediaCollections::CAMPUS_BANNER->value );

                    $campusProfile->addMedia( public_path( '/assets/app/school-' . rand( 1, 5 ) . '-logo.png' ) )->preservingOriginal()->toMediaCollection( MediaCollections::CAMPUS_LOGO->value );

                    $campusProfile->location_types()->attach( LocationType::all()->random( 2 ) );
                    $campusProfile->curricula()->attach( Curriculum::all()->random( 1 ) );
                    $campusProfile->sectors()->attach( Sector::all()->random( 1 ) );
                    $campusProfile->genders()->attach( SchoolGender::all()->random( 1 ) );
                    $campusProfile->school_types()->attach( SchoolType::all()->random( 1 ) );
                    $campusProfile->religions()->attach( Religion::all()->random( 1 ) );

                });
            }
        }

    }

}
