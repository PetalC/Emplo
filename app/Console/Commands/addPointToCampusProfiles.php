<?php

namespace App\Console\Commands;

use App\Models\CampusProfile;
use Illuminate\Console\Command;
use MatanYadaev\EloquentSpatial\Objects\Point;

class addPointToCampusProfiles extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:add-point-to-campus-profiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create update the location field of all campus profiles.';

    /**
     * Execute the console command.
     */
    public function handle() {

        $campus_profiles = CampusProfile::query()->whereNotNull( 'latitude' )->whereNotNull( 'longitude' )->get();

        foreach( $campus_profiles as $campus_profile ) {
            $campus_profile->location = new Point( $campus_profile->latitude, $campus_profile->longitude );
            $campus_profile->saveQuietly();
        }

    }

}
