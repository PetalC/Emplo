<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SeekGraph
{
    const BASE_URL = 'https://graphql.seek.com/graphql';

    private function _oauth($grantType="client_credentials")
    {
        $url = 'https://auth.seek.com/oauth/token';
        $audience = 'https://graphql.seek.com';

        if (env('APP_ENV') != 'production') {
            //$audience = 'https://test.graphql.seek.com';
        }
        
        $headers = array(
            'Content-Type: application/json',
            'User-Agent: Employo_v2.0',
        );

        $postParameters = array(
            'audience' => $audience,
            'client_id' => env('SEEK_CLIENT_ID'),
            'client_secret' => env('SEEK_CLIENT_SECRET'),
            'grant_type' => $grantType,
        );

        $handle = curl_init($url);

        try {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_POST, TRUE);
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($postParameters));
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $data = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $jsonData = json_decode($data);
            
            curl_close($handle);

            return $jsonData;
        } catch (\Exception $error) {
            curl_close($handle);
            return null;
        }
        
        return null;
    }

    private function _postQuery($query, $variables)
    {
        $url = self::BASE_URL;

        $headers = array(
            'Accept-Language: en-AU',
            'Authorization: Bearer '.$this->getPartnerToken(),
            'Content-Type: application/json',
            'User-Agent: Employo_v2.0',
        );
        
        // Build data to send
        $data = array(
            "query" => $query,
            "variables" => $variables,
        );

        // Encode data as JSON
        $payload = json_encode($data);

        // Initialize cURL session
        $handle = curl_init($url);

        try {
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_POST, TRUE);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $data = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $jsonData = json_decode($data);
            
            curl_close($handle);
            return $jsonData;

        } catch (\Exception $error) {
            curl_close($handle);
            return null;
        }

        return null;
    }

    public function getPartnerToken()
    {
        if (Cache::store('file')->has('seek_token')) {
            return Cache::store('file')->get('seek_token');
        }

        $jsonData = $this->_oauth();

        Cache::store('file')->put('seek_token', $jsonData->access_token, ($jsonData->expires_in - 120));
        return $jsonData->access_token;
    }

    public function getNearestLocation($latitude, $longitude, $schemeID, $first=1)
    {
        $query = <<<GRAPHQL
            query (\$first: Int!, \$geoLocation: GeoLocationInput!, \$schemeId: String!) {
                nearestLocations(
                    first: \$first
                    geoLocation: \$geoLocation
                    schemeId: \$schemeId
                )
                {
                    id {
                        value
                    }
                    contextualName
                    countryCode
                    currencies {
                        code
                    }
                }
            }
            GRAPHQL;

        $variables = array(
            "first" => $first,
            "geoLocation" => array(
                "latitude" => $latitude,
                "longitude" => $longitude,
            ),
            "schemeId" => $schemeID,
        );

        return $this->_postQuery($query, $variables);
    }

    public function getCategories($schemeID, $locationID)
    {
        $query = <<<GRAPHQL
            query (\$schemeId: String!, \$positionProfile: JobCategories_PositionProfileInput!) {
                jobCategories(schemeId: \$schemeId, positionProfile: \$positionProfile) {
                    id {
                        value
                    }
                    name
                    children {
                        id {
                            value
                        }
                        name
                    }
                }
            }
            GRAPHQL;

        $variables = array(
            "schemeId" => $schemeID,
            "positionProfile" => [
                "positionLocation" => $locationID
            ]
        );

        return $this->_postQuery($query, $variables);
    }

    public function getCategory($categoryID)
    {
        $query = <<<GRAPHQL
            query (\$id: String!) {
                jobCategory(id: \$id) {
                    id {
                        value
                    }
                    parent {
                        id {
                            value
                        }
                        name
                    }
                    name
                    children {
                        id {
                            value
                        }
                        name
                    }
                }
            }
            GRAPHQL;

        $variables = array(
            "id" => $categoryID,
        );

        return $this->_postQuery($query, $variables);
    }

    public function getAdSelections($positionProfile)
    {
        $query = <<<GRAPHQL
            query advertisementProducts(
                \$positionProfile: AdvertisementProducts_PositionProfileInput!
                \$selectedAdvertisementProductId: String
            ) {
                advertisementProducts(
                    positionProfile: \$positionProfile
                    selectedAdvertisementProductId: \$selectedAdvertisementProductId
                ) {
                    products {
                        id {
                            value
                        }
                        label
                        description
                        sellingPoints {
                            text
                        }
                        price {
                            summary
                        }
                        selected
                        features {
                            branding {
                                coverImageIndicator
                                logoIndicator
                            }
                            searchBulletPoints {
                                limit
                            }
                        }
                        payment {
                            summaryHtml
                        }
                    }
                    information
                }
            }
            GRAPHQL;

        $variables = array(
            "positionProfile" => $positionProfile,
        );

        return $this->_postQuery($query, $variables);
    }

    public function createJobPosition($positionOpening)
    {
        $query = <<<GRAPHQL
            mutation (\$input: PostPositionInput!) {
                postPosition(input: \$input) {
                    ... on PostPositionPayload_Success {
                        positionOpening {
                            documentId {
                                value
                            }
                        }
                        positionProfile {
                            profileId {
                                value
                            }
                        }
                    }
                    ... on PostPositionPayload_Conflict {
                        conflictingPositionOpening {
                            documentId {
                                value
                            }
                        }
                        conflictingPositionProfile {
                            profileId {
                                value
                            }
                        }
                    }
                }
            }
        GRAPHQL;
        
        $variables = $positionOpening;
    
        return $this->_postQuery($query, $variables);
    }
}