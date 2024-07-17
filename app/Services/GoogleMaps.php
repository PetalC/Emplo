<?php

namespace App\Services;

class GoogleMaps
{
    const BASE_URL = 'https://maps.googleapis.com/maps/api';
    
    public function __construct()
    {
        
    }

    public function getRecords($moduleName, $parameters=null)
    {
        try {
            $url = self::BASE_URL.'/'.$moduleName.'/json?key='.env('GOOGLE_MAPS_API_KEY');

            if ($parameters) {
                $url = $url.'&'.$parameters;
            }
            
            $headers = array(
                'Content-type: application/json',
            );
            
            $handle = curl_init($url);
            
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $data = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $jsonData = json_decode($data);
            
            curl_close($handle);
            
            return $jsonData;
        } catch(\Exception $error) {
            return '';
        }
        
        return '';
    }

    public function getGeolocation($country, $state, $city, $street, $zipcode)
    {
        /* Build the Address */
        $address = '';

        if (!empty($street)) {
            $address = $street;
        }

        if (!empty($city)) {
            $address .= ','.$city;
        }

        if (!empty($state)) {
            $address .= ','.$state;
        }

        if (!empty($zipcode)) {
            $address .= ','.$zipcode;
        }

        if (!empty($country)) {
            $address .= ','.$country;
        }

        if (empty($address)) {
            return false;
        }

        $address = urlencode($address);
        $parameter = 'address='.$address;
        
        return $this->getRecords('geocode', $parameter);
    }

    public function getDirection($origin, $destination)
    {
        $parameters = 'origins='.$origin.'&destinations='.$destination.'&departure_time=now';
        return $this->getRecords('distancematrix', $parameters);
    }
}