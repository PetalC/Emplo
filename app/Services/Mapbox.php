<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Mapbox
{
    const BASE_URL = 'https://maps.googleapis.com/maps/api';

    public function __construct() {}

    public function search($address) {

        try {

            $address = urlencode($address);

            $url = "https://api.mapbox.com/search/geocode/v6/forward?q={$address}&access_token=" . env('MAPBOX_ACCESS_TOKEN');

            $response = Http::get( $url );

            $addresses = [];

            if( $response->ok() ){

                $data = $response->json();

                foreach( $data['features'] as $feature ){
                    $addresses[] = [
                        'address' => $feature['properties']['full_address'],
                        'latitude' => $feature['properties']['coordinates']['latitude'],
                        'longitude' => $feature['properties']['coordinates']['longitude'],
                        'context' => $feature['properties']['context']
                    ];
                }

            }

            return $addresses;

        } catch(\Exception $error) {
            return [];
        }

    }

//    public function getGeolocation($country, $state, $city, $street, $zipcode)
//    {
//        /* Build the Address */
//        $address = '';
//
//        if (!empty($street)) {
//            $address = $street;
//        }
//
//        if (!empty($city)) {
//            $address .= ','.$city;
//        }
//
//        if (!empty($state)) {
//            $address .= ','.$state;
//        }
//
//        if (!empty($zipcode)) {
//            $address .= ','.$zipcode;
//        }
//
//        if (!empty($country)) {
//            $address .= ','.$country;
//        }
//
//        if (empty($address)) {
//            return false;
//        }
//
//        $address = urlencode($address);
//        $parameter = 'address='.$address;
//
//        return $this->getRecords('geocode', $parameter);
//    }
//
//    public function getDirection($origin, $destination)
//    {
//        $parameters = 'origins='.$origin.'&destinations='.$destination.'&departure_time=now';
//        return $this->getRecords('distancematrix', $parameters);
//    }
}
