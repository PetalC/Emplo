<?php

namespace App\Services;

use App\Models\RemainingScope;
use App\Models\Workshop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ZohoService {
    public const API_URL = 'https://www.zohoapis.com.au';



    /**
     * Core functions for this class. Please add any new functions above this
     */
    private static function getAccessToken() {

        $key_name = md5( 'zoho_access_token' );

        $access_token = Cache::get( $key_name );

        if ( ! $access_token ) {

            $url = sprintf(
                'https://accounts.zoho.com.au/oauth/v2/token?refresh_token=%s&client_id=%s&client_secret=%s&grant_type=refresh_token',
                env( 'ZOHO_REFRESH_TOKEN' ),
                env( 'ZOHO_CLIENT_ID' ),
                env( 'ZOHO_CLIENT_SECRET' ),
            );

            $response = Http::post( $url );

            $response_data = json_decode( $response->body() );

            if ( ! $response->ok() || property_exists( $response_data, 'error' ) ) {
                Log::error( 'Invalid Response - getAccessToken - ' . json_encode( $response_data ) );
                throw new \Exception( 'Invalid Response - getAccessToken' );
            }

            $access_token = $response_data->access_token;

            Cache::put( $key_name, $access_token, 15 * 60 ); //Cache for 15 minutes.

        }

        return $access_token;

    }

    public static function _getObject( $module, $id ) {

        $url = sprintf( '%s/crm/v4/%s/%s', self::API_URL, $module, $id );

        $request = self::_get( $url );

        $results = json_decode( $request->body() );

        return $results->data[0];

    }

    private static function _getAll( $module, $fields ) {

        $has_more = true;
        $page = 1;
        $items = [];

        $_fields = ( is_array( $fields ) ) ? implode( ',', $fields ) : $fields;

        while ( $has_more ) {

            $url = sprintf( '%s/crm/v4/%s?fields=%s&page=%s&include_child=true', self::API_URL, $module, $_fields, $page );

            $request = self::_get( $url, [
                //                'If-Modified-Since' => Carbon::now()->subHour( 1 )->format( DATE_ATOM )
            ] );

            $results = json_decode( $request->body() );

//            Log::debug( $request->body() );

            if ( ! empty( $results->data ) ) {
                foreach ( $results->data as $result ) {
                    $items[] = $result;
                }
            }

            if ( $results && property_exists( $results, 'info' ) ) {
                $has_more = $results->info->more_records;
            } else {
                Log::error( 'No Results Found' );
                Log::error( json_encode( $request ) );
                $has_more = false;
            }

            $page++;

        }

        return $items;

    }

    private static function _getLatest( $module, $fields ) {

        $page = 1;
        $items = [];

        $_fields = ( is_array( $fields ) ) ? implode( ',', $fields ) : $fields;

        $url = sprintf( '%s/crm/v4/%s?fields=%s&page=1&include_child=true&sort_by=Modified_Time', self::API_URL, $module, $_fields, $page );

        $request = self::_get( $url );

        $results = json_decode( $request->body() );

        if ( ! empty( $results->data ) ) {
            foreach ( $results->data as $result ) {
                $items[] = $result;
            }
        }

        return $items;

    }

    /**
     * @return false|\GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private static function _post( $url, $data, Media|bool $attachment = false, $extra_headers = [] ) {

        $access_token = self::getAccessToken();

        $headers = array_merge( $extra_headers, [
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
        ] );

        $request = Http::withHeaders( $headers );

        if ( $attachment ) {
            $request->attach( 'file', file_get_contents( $attachment->getPath() ), $attachment->file_name );
        }

        return $request->post( $url, $data );

    }

    private static function _patch( $url, $data, Media|bool $attachment = false, $extra_headers = [] ) {

        //        Log::debug( sprintf( 'ZOHO Patch Request Called - %s', $url ) );
        //        Log::debug( json_encode( $data ) );

        $access_token = self::getAccessToken();

        $headers = array_merge( $extra_headers, [
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
        ] );

        $request = Http::withHeaders( $headers );

        if ( $attachment ) {
            $request->attach( 'file', file_get_contents( $attachment->getPath() ), $attachment->file_name );
        }

        return $request->patch( $url, $data );

    }

    private static function _put( $url, $data, $extra_headers = [] ) {

        //        Log::debug( sprintf( 'ZOHO Put Request Called - %s', $url ) );
        //        Log::debug( json_encode( $data ) );

        $access_token = self::getAccessToken();

        $headers = array_merge( $extra_headers, [
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
        ] );

        return Http::withHeaders( $headers )->put( $url, $data );

    }

    private static function _get( $url, $extra_headers = [] ) {

        //        Log::debug( sprintf( 'ZOHO Get Request Called - %s', $url ) );

        $access_token = self::getAccessToken();

        $headers = array_merge( $extra_headers, [
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
        ] );

        return Http::withHeaders( $headers )->get( $url );

    }

    private static function _delete( $url, $data = [], array $additional_headers = [] ) {
        //
        //        Log::debug( sprintf( 'ZOHO Delete Request Called - %s', $url ) );
        //        Log::debug( json_encode( $data ) );

        $access_token = self::getAccessToken();

        $headers = array_merge( [
            'Authorization' => 'Zoho-oauthtoken ' . $access_token,
        ], $additional_headers );

        return Http::withHeaders( $headers )->delete( $url, $data );

    }
}
