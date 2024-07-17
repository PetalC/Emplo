<?php

namespace App\Console\Commands;

use App\Facades\MapboxFacade as Mapbox;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ProcessLatitudeLongitude extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:process-latitude-longitude';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

//        $tried_profiles = Cache::get( 'tried_profiles', [] );

        $profiles = \App\Models\CampusProfile::whereNull('latitude')->whereNull('longitude')->take( 100 )->get();

        foreach( $profiles as $profile ){

            $results = Mapbox::search( $profile->address ?? '' . ' ' . $profile->city ?? '' . ' ' . $profile->state ?? '' . ' ' . $profile->postcode ?? '' . ' ' . $profile->country ?? '' );
            if( $results ){
                $profile->latitude = $results[0]['latitude'];
                $profile->longitude = $results[0]['longitude'];
                $profile->save();

                $this->info( 'Updated Latitude and Longitude for ' . $profile->name . ' Campus Profile.' );
            } else {
                $this->info( 'Could not find Latitude and Longitude for ' . $profile->name . ' Campus Profile.' );
            }

        }

    }

}
