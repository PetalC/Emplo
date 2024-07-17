<?php

namespace Database\Seeders;

use App\Enums\PlanFeatures;
use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;

class PlanSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {

        foreach( PlanFeatures::cases() as $feature ){

            if( in_array( $feature, [ PlanFeatures::ADVERTISING_CREDITS, PlanFeatures::MULTI_USER, PlanFeatures::CRIMINAL_CLEARANCE_CHECKS, PlanFeatures::ID_VERIFICATIONS, PlanFeatures::PAID_SOCIAL_BOOSTERS ] ) ){
                Feature::create( [
                    'name' => $feature->value,
                    'consumable' => true,
                    'quota' => true,
                ] );
            } else {
                Feature::create( [
                    'name' => $feature->value,
                    'consumable' => false,
                ] );
            }
        }

        $showcase_features = [
            PlanFeatures::EMPLOYER_PROFILE,
            PlanFeatures::SINGLE_USER,
            PlanFeatures::COMPLIMENTARY_SETUP,
            PlanFeatures::RESOURCE_LIBRARY,
        ];

        $showcase = \App\Models\Plan::create( [
            'name' => 'Showcase',
            'price' => '',
            'retail_price' => '',
            'description' => 'Showcase your school. Let our website drive candidate traffic to yours.',
            'grace_days' => 30,
            'periodicity_type' => PeriodicityType::Year,
            'periodicity' => 1,
            'order' => 1,
        ] );

        foreach( $showcase_features as $feature ){
            $showcase->features()->attach( Feature::where( 'name', $feature )->first() );
        }

        $attract_features = [
            PlanFeatures::DASHBOARD->value => true,
            PlanFeatures::EMPLOYER_PROFILE->value => true,
            PlanFeatures::MULTI_USER->value => 99,
            PlanFeatures::COMPLIMENTARY_SETUP->value => true,
            PlanFeatures::RESOURCE_LIBRARY->value => true,
            PlanFeatures::STAFF_ROOM->value => true,
            PlanFeatures::JOB_CENTER->value => true ,
            PlanFeatures::PAID_SOCIAL_BOOSTERS->value => 2
        ];

        $attract = \App\Models\Plan::create( [
            'name' => 'Attract',
            'price' => '',
            'retail_price' => '',
            'description' => 'Attract followers 365 days per year and broaden your advertising reach at the click of a button.',
            'grace_days' => 30,
            'periodicity_type' => PeriodicityType::Year,
            'periodicity' => 1,
            'order' => 2,
        ] );

        foreach( $attract_features as $feature => $value ){
            if( is_bool( $value ) ){
                $attract->features()->attach( Feature::where( 'name', $feature )->first() );
            } else {
                $attract->features()->attach( Feature::where( 'name', $feature )->first(), [ 'charges' => $value ] );
            }
        }

        $enhance_features = [
            PlanFeatures::DASHBOARD->value => true,
            PlanFeatures::EMPLOYER_PROFILE->value => true,
            PlanFeatures::MULTI_USER->value => 99,
            PlanFeatures::COMPLIMENTARY_SETUP->value => true,
            PlanFeatures::RESOURCE_LIBRARY->value => true,
            PlanFeatures::STAFF_ROOM->value => true,
            PlanFeatures::JOB_CENTER->value => true,
            PlanFeatures::PAID_SOCIAL_BOOSTERS->value => 4,
            PlanFeatures::ATS->value => true,
            PlanFeatures::ADVERTISING_CREDITS->value => 27,
        ];

        $enhance = \App\Models\Plan::create( [
            'name' => 'Enhance',
            'price' => '',
            'retail_price' => '',
            'description' => 'Enhance your recruitment. Access an otherwise untapped source of teachers, non-teachers and leaders. Let automated compliance and collaboration guide your decision-making..',
            'grace_days' => 30,
            'periodicity_type' => PeriodicityType::Year,
            'periodicity' => 1,
            'order' => 3,
        ] );

        foreach( $enhance_features as $feature => $value ){
            if( is_bool( $value ) ){
                $enhance->features()->attach( Feature::where( 'name', $feature )->first() );
            } else {
                $enhance->features()->attach( Feature::where( 'name', $feature )->first(), [ 'charges' => $value ] );
            }
        }

        $safeguard_features = [
            PlanFeatures::DASHBOARD->value => true,
            PlanFeatures::EMPLOYER_PROFILE->value => true,
            PlanFeatures::MULTI_USER->value => 99,
            PlanFeatures::COMPLIMENTARY_SETUP->value => true,
            PlanFeatures::RESOURCE_LIBRARY->value => true,
            PlanFeatures::STAFF_ROOM->value => true,
            PlanFeatures::JOB_CENTER->value => true,
            PlanFeatures::ATS->value => true,
            PlanFeatures::PAID_SOCIAL_BOOSTERS->value => 6,
            PlanFeatures::ADVERTISING_CREDITS->value => 54,
            PlanFeatures::AI_FAQ_BOT->value => true,
            PlanFeatures::ID_VERIFICATIONS->value => 15,
            PlanFeatures::CRIMINAL_CLEARANCE_CHECKS->value => 15,
        ];

        $safeguard = \App\Models\Plan::create( [
            'name' => 'Safeguard',
            'price' => '',
            'retail_price' => '',
            'description' => 'Safeguard your current and future recruitment. Leverage AI, automations and integrations with licensing and child protection authorities. Effortlessly generate reports to inform planning and compliance.',
            'grace_days' => 30,
            'periodicity_type' => PeriodicityType::Year,
            'periodicity' => 1,
            'order' => 4,
        ] );

        foreach( $safeguard_features as $feature => $value ){
            if( is_bool( $value ) ){
                $safeguard->features()->attach( Feature::where( 'name', $feature )->first() );
            } else {
                $safeguard->features()->attach( Feature::where( 'name', $feature )->first(), [ 'charges' => $value ] );
            }
        }

    }

}
