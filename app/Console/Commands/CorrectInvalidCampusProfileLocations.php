<?php

namespace App\Console\Commands;

use App\Facades\MapboxFacade;
use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\Job;
use App\Services\Mapbox;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CorrectInvalidCampusProfileLocations extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:correct-campus-profile-locations {max=50} {--refresh-locations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle() {

        $invalid_locations = Cache::get( 'invalid_campus_profile_locations' );

        if( $this->option( 'refresh-locations' ) || ! $invalid_locations ){

            $invalid_locations = [];

            foreach( \App\Models\State::all() as $state ){

                $this->info( 'Processing State ' . $state->name );

                $profiles = \App\Models\CampusProfile::query()
                    ->where( 'state', '=', $state->name )
                    ->whereNotWithin( 'location', $state->geometry )
                    ->get();

                foreach( $profiles as $profile ){

                    $invalid_locations[] = [
                        'id' => $profile->id,
                        'attempted_count' => 0,
                    ];

                }

                $this->info( 'Completed State ' . $state->name );

            }

            Cache::put( 'invalid_campus_profile_locations', array_values( $invalid_locations ) );

        }

        $this->info( 'Found ' . count( $invalid_locations ) . ' invalid campus profile locations.' );

        $max = $this->argument( 'max' );

//        $i = 0;

        for( $i = 0; $i <= $max; $i++ ){

            if( ! isset( $invalid_locations[ $i ] ) ){
                break;
            }

            if( $invalid_locations[ $i ]['attempted_count'] >= 3 ){
                $this->error( 'Attempted to correct location 3 times for ' . $invalid_locations[ $i ]['id'] );
                continue;
            }

            $profile = \App\Models\CampusProfile::find( $invalid_locations[ $i ]['id'] );

            if( ! $profile ){
                $this->error( 'Could not find Campus Profile ' . $invalid_locations[ $i ] );
                unset( $invalid_locations[ $i ] );
                continue;
            }

            $this->info( 'Processing Campus Profile ' . $profile->name );

            /**
             * Lookup the address and update the lat/lng
             */
            $address_results = MapboxFacade::search( $profile->full_address );

            if( ! $address_results ){
                $this->error( 'Could not find address ' . $profile->full_address );
                continue;
            }

            $profile->latitude = $address_results[0]['latitude'];
            $profile->longitude = $address_results[0]['longitude'];
            $profile->save();

            /**
             * Check if the location is now valid
             */
            $state = \App\Models\State::where( 'name', $profile->state )->first();

            if( ! $state ){
                $this->error( 'Could not find State ' . $profile->state );
                continue;
            }

            $check = CampusProfile::query()
                ->where( 'id', '=', $profile->id )
                ->whereWithin( 'location', $state->geometry )
                ->exists();

            if( $check ){
                $this->info( 'Location is now valid for ' . $profile->name );
                unset( $invalid_locations[ $i ] );
            } else {
                $invalid_locations[ $i ]['attempted_count']++;
                $this->alert( 'Location is still invalid for ' . $profile->name );
                continue;
            }

        }

        Cache::put( 'invalid_campus_profile_locations', array_values( $invalid_locations ) );

    }

}
