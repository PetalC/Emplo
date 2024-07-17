<?php

namespace App\Services;

use Carbon\Carbon;
use App\Services\ZohoAuth;

class ZohoRecruit
{
    const BASE_URL = 'https://recruit.zoho.com.au/recruit/v2';

    public function __construct()
    {
        
    }

    public function getRecords($moduleName, $recordID=null, $modifiedAt='')
    {
        $url = self::BASE_URL.'/'.$moduleName;

        if ($recordID) {
            $url = $url.'/'.$recordID;
        }

        $authAPI = new ZohoAuth();
        $access = $authAPI->getAccessToken();
        
        if ($access) {
            $headers = array(
                'Authorization: Zoho-oauthtoken  '.$access->access_token,
                'Content-type: application/json',
            );

            if ($modifiedAt != '') {
                $headers[] = 'If-Modified-Since: '.$modifiedAt;
            }
            
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
        }
        
        return null;
    }

    public function searchRecord($moduleName, $criteria)
    {
        $url = self::BASE_URL.'/'.$moduleName.'/search?'.$criteria;

        $authAPI = new ZohoAuth();
        $access = $authAPI->getAccessToken();
        
        if ($access) {
            $headers = array(
                'Authorization: Zoho-oauthtoken  '.$access->access_token,
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
        }
        
        return null;
    }

    public function insertRecord($fields, $moduleName)
    {
        $url = self::BASE_URL.'/'.$moduleName;
        
        $access = Access::first();
        $authAPI = new AuthAPI();
        $access = $authAPI->getAccessToken();

        if ($access) {

            $headers = array(
                'Content-type: application/json',
                'Authorization: Zoho-oauthtoken  '.$access->access_token,
            );
            
            $handle = curl_init($url);
            
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_POST, TRUE);
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $data = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $jsonData = json_decode($data);
            
            curl_close($handle);

            return $jsonData;
        }

        return null;
    }

    public function updateRecord($fields, $moduleName)
    {
        $url = self::BASE_URL.'/'.$moduleName;
        
        $access = Access::first();
        $authAPI = new AuthAPI();
        $access = $authAPI->getAccessToken();

        if ($access) {

            $headers = array(
                'Content-type: application/json',
                'Authorization: Zoho-oauthtoken  '.$access->access_token,
            );
            
            $handle = curl_init($url);
            
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $data = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $jsonData = json_decode($data);
            
            curl_close($handle);

            return $jsonData;
        }

        return null;
    }

    public function jobApplication($candidateZohoID, $jobZohoID)
    {
        $fields = new \stdClass();

        if ($candidateZohoID && $jobZohoID) {
            $fields->data = [];
            $data = new \stdClass();
            
            $data->jobids = [$jobZohoID];
            $data->ids = [$candidateZohoID];

            $url = self::BASE_URL.'/Candidates/actions/associate';
            
            $access = Access::first();
            $authAPI = new AuthAPI();
            $access = $authAPI->getAccessToken();

            $fields->data[] = $data;

            if ($access) {

                $headers = array(
                    'Content-type: application/json',
                    'Authorization: Zoho-oauthtoken  '.$access->access_token,
                );
                
                $handle = curl_init($url);
                
                curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($fields));
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
                
                $data = curl_exec($handle);
                $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                $jsonData = json_decode($data);
                
                curl_close($handle);

                return true;
            }
        }

        return false;
    }
}