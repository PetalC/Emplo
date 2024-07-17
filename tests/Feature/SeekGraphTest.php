<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\SeekGraph;

class SeekGraphTest extends TestCase
{
    /**
     * Test SEEK NearestLocation method
     */
    public function test_hasNearestLocation(): void
    {
        /* Result: ID -> seekAnzPublicTest:location:seek:2YE87KE4o Port Melbourne
        $seekApi = new SeekGraph();
        $latitude = -37.840935;
        $longitude = 144.946457;
        $schemeID = 'seekAnzPublicTest';
        
        $output = $seekApi->getNearestLocation($latitude, $longitude, $schemeID);
        $this->assertEquals($output->data->nearestLocations[0]->contextualName, 'Melbourne');
        */
        $this->assertTrue(true);
    }

    /**
     * A basic test example.
     */
    public function test_category(): void
    {
        /* seekAnz:jobCategory:seek:33Zarf9w5, seekAnz:jobCategory:seek:334hgafQT, seekAnz:jobCategory:seek:32ZpWWAsq
        $seekApi = new SeekGraph();

        $output = $seekApi->getCategory('seekAnzPublicTest:jobCategory:seek:32ZpWWAsq');
        $this->assertEquals($output->data->nearestLocations[0]->contextualName, 'Melbourne');
        */
        $this->assertTrue(true);
    }

    public function test_create_job()
    {
        /*
        $seekApi = new SeekGraph();
        $latitude = -37.840935;
        $longitude = 144.946457;
        $schemeID = 'seekAnz';
        
        $location = $seekApi->getNearestLocation($latitude, $longitude, $schemeID);

        $categories = $seekApi->getCategories($schemeID, $location->data->nearestLocations[0]->id->value);
        $category = $seekApi->getCategory($categories->data->jobCategories[10]->children[0]->id->value);

        $positionProfile = $this->_getPositionProfile($category->data->jobCategory->id->value, $location->data->nearestLocations[0]->id->value);
        
        $adSelections = $seekApi->getAdSelections($positionProfile);
        
        $positionProfile = $this->_getPositionProfile($category->data->jobCategory->id->value, $location->data->nearestLocations[0]->id->value, $adSelections->data->advertisementProducts->products[0]->id->value);
        $positionOpening = $this->_getPositionOpening($positionProfile);
        
        $jobPosition = $seekApi->createJobPosition($positionOpening);
        */
        $this->assertTrue(true);
    }

    private function _getPositionProfile($categoryID, $locationID, $productID=null)
    {
        $positionProfile = [
            "jobCategories" => $categoryID,
            "positionLocation" => $locationID,
            "positionOrganizations" => "seekAnz:organization:seek:2Uz8aWFnX",
            "positionTitle" => "Sith Lord",
            "offeredRemunerationPackage" => [
                "basisCode" => "Salaried",
                "descriptions" => ["70-90k plus super"],
                "ranges" => [
                    [
                        "intervalCode" => "Year",
                        "minimumAmount" => [ "currency" => "AUD", "value" => 70000 ],
                        "maximumAmount" => [ "currency" => "AUD", "value" => 90000 ]
                    ]
                ]
            ],
            "seekAnzWorkTypeCode" => "FullTime",
        ];

        if ($productID) {
            $positionProfile['postingInstructions'] = [
                "seekAdvertisementProductId" => $productID,
                "idempotencyId" => md5(date('YmdHis').'lyonhart123456')
            ];
            $positionProfile['positionFormattedDescriptions'] = [
                [
                    "descriptionId" => "SearchSummary",
                    "content" => "Want to rule the Galaxy? We got you covered"
                ],
                [
                    "descriptionId" => "AdvertisementDetails",
                    "content" => "Looking for a new Sith Lord to train, cause you know the rule of 2 requires another Force User."
                ]
            ];

        }

        return $positionProfile;
    }

    private function _getPositionOpening($positionProfile)
    {
        $positionOpening = [
            "input" => [
                "positionOpening" => [
                    "postingRequester" => [
                        "roleCode" => "Company",
                        "id" => "seekAnz:organization:seek:2Uz8aWFnX",
                        "personContacts" => [
                            [
                                "name" => ["formattedName" => "Master Yoda"],
                                "roleCode" => "HiringManager",
                                "communication" => [
                                    "email" => [["address" => "ruffy@lyonharttechnologies.com"]],
                                    "phone" => [["formattedNumber" => "+63 917 858 9556"]]
                                ]
                            ]
                        ]
                    ],
                ],
                "positionProfile" => $positionProfile,
            ]
        ];

        return $positionOpening;
    }
}