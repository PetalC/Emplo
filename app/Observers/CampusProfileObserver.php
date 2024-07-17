<?php

namespace App\Observers;

use App\Models\CampusProfile;
use MatanYadaev\EloquentSpatial\Objects\Point;

class CampusProfileObserver
{
    /**
     * Handle the CampusProfile "created" event.
     */
    public function created(CampusProfile $campusProfile): void
    {
        //
    }

    /**
     * Handle the CampusProfile "updated" event.
     */
    public function updated(CampusProfile $campusProfile): void {

        /**
         * If lat/lng are dirty, update the location field
         */
        if( $campusProfile->wasChanged( [ 'latitude', 'longitude' ] ) ) {
            $campusProfile->location = new Point( $campusProfile->latitude, $campusProfile->longitude );
        }

        /**
         * If Point is dirty, update the lat/lng
         */
        if( $campusProfile->wasChanged( 'location' ) ) {

            /**
             * @var Point $point
             */
            $point = $campusProfile->location;
            $campusProfile->latitude = $point->latitude;
            $campusProfile->longitude = $point->longitude;
        }



        /**
         * Try to parse the youtube ID from the video URL
         */
        $matches = [];

        preg_match('/youtu(?:.*\/v\/|.*v\=|\.be\/)([A-Za-z0-9_\-]{11})/', $campusProfile->video_url, $matches);

        if( $matches && ! empty( $matches ) ) {
            $campusProfile->youtube_embed_url = 'https://youtube.com/embed/' . $matches[1];

        }

        if( $campusProfile->isDirty() ){
            $campusProfile->saveQuietly();
        }

    }

    /**
     * Handle the CampusProfile "deleted" event.
     */
    public function deleted(CampusProfile $campusProfile): void
    {
        //
    }

    /**
     * Handle the CampusProfile "restored" event.
     */
    public function restored(CampusProfile $campusProfile): void
    {
        //
    }

    /**
     * Handle the CampusProfile "force deleted" event.
     */
    public function forceDeleted(CampusProfile $campusProfile): void
    {
        //
    }
}
