<?php

namespace App\Console\Commands;

use App\Models\Campus;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ValidateCampusProfileLocations extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:validate-campus-profile-locations';

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

        $start = microtime(true);

        $count = 0;

        foreach( \App\Models\State::all() as $state ){

            $this->info( 'Processing State ' . $state->name );

            $profiles = \App\Models\CampusProfile::query()
                ->where( 'state', '=', $state->name )
                ->whereNotWithin( 'location', $state->geometry )
                ->get();

            $count += $profiles->count();

            foreach( $profiles as $profile ){
                $this->alert( $profile->name . ' - ' . '/nova/resources/campus-profiles/' . $profile->id );
            }

            $this->info( 'Completed State ' . $state->name );

        }

        $this->info( 'Total profiles: ' . $count );

        $total_time = microtime(true) - $start;

        $this->info( 'Total time: ' . $total_time );

    }

}
