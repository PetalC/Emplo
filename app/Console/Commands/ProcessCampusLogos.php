<?php

namespace App\Console\Commands;

use App\Enums\MediaCollections;
use App\Facades\MapboxFacade as Mapbox;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ProcessCampusLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:process-campus-logos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process a batch of Campus Logos.';

    /**
     * Execute the console command.
     */
    public function handle() {

        $tried_profiles = Cache::get( 'campus_logo_tried_ids', [] );

        $profiles = \App\Models\CampusProfile::query()
            ->whereNotIn( 'id', $tried_profiles )
            ->whereDoesntHave( 'media', function( $query ){
                $query->where( 'collection_name', MediaCollections::CAMPUS_LOGO->value );
            } )
            ->take( 50 )
            ->get();

        foreach( $profiles as $profile ){

            $this->info( 'Processing Campus Logo for ' . $profile->name );

            try{
                $profile->findLogo();
            } catch( \Exception $e ){
                $this->error( 'An error occurred. ' . $e->getMessage() );
            }

            $tried_profiles[] = $profile->id;

        }

        Cache::put( 'campus_logo_tried_ids', $tried_profiles );

    }

}
