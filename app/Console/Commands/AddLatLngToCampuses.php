<?php

namespace App\Console\Commands;

use App\Models\Campus;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddLatLngToCampuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:locations-on-campuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        if( env('APP_ENV') !== 'local' ){
            $this->error('This command can only be run in local environment');
            return;
        }

        $locations = [
            [
                'lat' => -27.470125,
                'lng' => 153.021072
            ], //Brisbane
            [
                'lat' => -33.865143,
                'lng' => 151.209900,
            ], // Sydney
            [
                'lat' => -37.840935,
                'lng' => 144.946457
            ], // Melbourne
            [
                'lat' => -31.953512,
                'lng' => 115.857048
            ], // Perth
        ];

        $campuses = Campus::all();

        foreach( $campuses as $campus ){

            $loc = $locations[ rand( 0, 3 ) ];

            $campus->update([
                'latitude' => $loc['lat'],
                'longitude' => $loc['lng'],
            ]);
        }

    }
}
