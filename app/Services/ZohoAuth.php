<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\ZohoAccess;

class ZohoAuth
{
    const BASE_URL = 'https://accounts.zoho.com.au/oauth/v2/token';

    public function __construct()
    {
        $this->access = null;
    }

    public function getAccessToken()
    {
        $now = date('Y-m-d H:i:s');

        $this->access = ZohoAccess::first();

        if (!$this->access->access_token) {
            return $this->_accessToken;
        }

        if (strtotime($now) >= strtotime($this->access->expires_at)) {
            return $this->_refreshToken();
        }

        return $this->access;
    }

    private function _accessToken()
    {
        $url = self::BASE_URL;

        $headers = array(
            'Content-type: application/x-www-form-urlencoded',
        );

        $postParameters = array(
            'grant_type' => 'authorization_code',
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'redirect_uri' => env('ZOHO_AUTH_CALLBACK'),
            'code' => $this->access->auth_code
        );

        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($postParameters));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $data = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $jsonData = json_decode($data);

        curl_close($handle);

        $today = Carbon::now();
        $expires_at = $today->addSeconds(($jsonData->expires_in - 120));

        $this->access->access_token = $jsonData->access_token;
        $this->refresh_token = $jsonData->refresh_token;
        $this->access->expires_at = $expires_at->format("Y-m-d H:i:s");

        $this->access->save();

        return $this->access;
    }

    private function _refreshToken()
    {
        $url = $url = self::BASE_URL;

        $headers = array(
            'Content-type: application/x-www-form-urlencoded',
        );

        $postParameters = array(
            'grant_type' => 'refresh_token',
            'client_id' => env('ZOHO_CLIENT_ID'),
            'client_secret' => env('ZOHO_CLIENT_SECRET'),
            'refresh_token' => $this->access->refresh_token
        );

        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_POST, TRUE);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($postParameters));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $data = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $jsonData = json_decode($data);

        curl_close($handle);

        $today = Carbon::now();
        $expires_at = $today->addSeconds(($jsonData->expires_in - 120));

        $this->access->access_token = $jsonData->access_token;
        $this->access->expires_at = $expires_at->format("Y-m-d H:i:s");

        $this->access->save();

        return $this->access;
    }
}
