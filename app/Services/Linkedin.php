<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\LinkedinAccess;

class Linkedin
{
    const SCOPE = 'r_emailaddress r_liteprofile w_member_social';
    const API_BASE_URL = 'https://api.linkedin.com/rest';
    const LINKEDIN_VERSION = "202306";

    protected $accessToken = '';

    public function __construct()
    {

    }
    
    public function authorise()
    {
        $getParameters = array(
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => \URL::To('/auth/linkedin/callback'),
            'scope' => self::SCOPE,
        );
        
        $getParameters = http_build_query($getParameters, null, '&', PHP_QUERY_RFC3986);
        
        return "https://www.linkedin.com/oauth/v2/authorization?".$getParameters;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }
    
    public function validateToken($userID)
    {      
        $auth = LinkedinAccess::where('user', $userID)->first();
        
        if (!$auth) {
            return $this->authorise();
        }
        
        /*  Token is expired    */
        if (date('Y-m-d H:i:s') >= date("Y-m-d H:i:s", strtotime($auth->expires_at))) {
            return $this->authorise();
        }
        
        $this->setAccessToken($auth->access_token);
        return $auth->access_token;
    }
    
    public function accessToken($authCode)
    {
        $url = "https://www.linkedin.com/oauth/v2/accessToken";
        $postData = array(
            'grant_type' => 'authorization_code',
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'code' => $authCode,
            'redirect_uri' => \URL::To('/auth/linkedin/callback'),
        );
        
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );

        $handle = curl_init($url);
        
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $data = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $jsonData = json_decode($data);
        
        curl_close($handle);
        
        return $jsonData;
    }
    
    public function getRecords($endpoint, $recordID=null)
    {
        if (empty($this->accessToken)) {
            return false;
        }

        $url = self::API_BASE_URL.'/'.$endpoint;

        if ($recordID) {
            $url = $url.'/'.$recordID;
        }

        $headers = array(
            'Authorization: Bearer '.$this->accessToken,
            'Content-type: application/json',
            'Linkedin-Version: '.self::LINKEDIN_VERSION
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

    private function insertRecord($endpoint, $fields)
    {
        if (empty($this->accessToken)) {
            return false;
        }
        
        $url = self::API_BASE_URL.'/'.$endpoint;
        
        $headers = array(
            'Authorization: Bearer '.$this->accessToken,
            'Content-type: application/json',
            'Linkedin-Version: '.self::LINKEDIN_VERSION
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

    public function createOrganizationPost($school)
    {
        $fields = new \stdClass();

        if ($school) {
            $fields->author = "urn:li:organization:".$school->linkedin_id;
            $fields->commentary = $content;
            $fields->visibility = 'PUBLIC';
            $fields->lifecycleState = 'PUBLISHED';
            $fields->isReshareDisabledByAuthor = false;

            $fields->distribution = new \stdClass();
            $fields->distribution->feedDistribution = "MAIN_FEED";

            $this->insertRecord('posts', $fields);
        }
    }

    public function getProfile()
    {
        return $this->getRecords('me');
    }


    public function getOrganizations($linkedinID)
    {
        return $this->getRecords('organizations', $linkedinID);
    }
}