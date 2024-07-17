<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Curriculum;
use App\Models\Job;
use App\Models\JobLength;
use App\Models\PositionTitle;
use App\Models\PositionType;
use App\Models\PositionMap;
use App\Models\Religion;
use App\Models\CitizenshipType;
use App\Models\School;
use App\Models\SchoolGender;
use App\Models\SchoolType;
use App\Models\Sector;
use App\Models\Subject;
use App\Models\User;
use App\Models\LocationType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TaxonomySeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $job_lengths = [
            'Permanent',
            'Casual (non-teaching)',
            'Term Contract',
            '2 Term Contract',
            '3 Term Contract',
            '12 Month Contract',
            'Relief',
            'Short Term'
        ];

        foreach($job_lengths as $job_length) {
            JobLength::create( [
                'name' => $job_length,
            ] );
        }

        $right_to_work = [
            'Australian Citizen',
            'Australian Permanent Resident',
            'Other Australian VISA',
            'Sponsorship is required',
            'Working Holiday VISA'
        ];

        foreach($right_to_work as $rtw) {
            CitizenshipType::create( [
                'name' => $rtw
            ]);
        }

        $location_types = [
            'Coastal',
            'Metropolitan',
            'Regional',
        ];

        foreach($location_types as $location_type) {
            LocationType::create( [
                'name' => $location_type,
            ] );
        }


        $position_types = [
            'Administration',
            'Boarding Staff',
            'Building & Maintenance (Groundskeepers, Farmhands)',
            'Business / Finance Manager',
            'Canteen / Tuck Shop',
            'Chaplin',
            'Cleaner',
            'Coach',
            'Counsellor',
            'Data Analyst',
            'Diverse Learning / Special Needs',
            'Finance & Payroll',
            'Head of Faculty / Department',
            'Head of Year',
            'Human Resources',
            'Kindergarten / Early Childhood',
            'Library / Information Services',
            'Marketing and Communication',
            'Middle Management',
            'Middle School teacher',
            'Nurse / First Aid Officer',
            'OSHC',
            'Other',
            'Personal/Executive Assistant',
            'Primary Teacher',
            'Principal / Head of School',
            'Psychologist',
            'Secondary Teacher',
            'Senior Leadership',
            'Support Position',
            'Technician',
            'Transport & Logistics',
            'Tutor'
        ];

        $positionMap = [
            ['position' => 1, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 2, 'ton' => 'Boarding Staff', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 3, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 4, 'ton' => 'Business / Finance Manager', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 5, 'ton' => 'Canteen', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 6, 'ton' => 'Chaplains / Pastoral Care', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 7, 'ton' => 'Cleaners', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 8, 'ton' => 'Coach', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 9, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 10, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 11, 'ton' => 'All Grade Levels (P-12)', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:363zj3caB'],
            ['position' => 12, 'ton' => 'Business / Finance Manager', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 13, 'ton' => 'Head of Faculty / Department', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 14, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 15, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 16, 'ton' => 'Kindergarten / ELC / Early Childhood', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:36Ysu876o'],
            ['position' => 17, 'ton' => 'Teacher Librarian', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:334hgafQT'],
            ['position' => 18, 'ton' => 'Marketing Communications', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 19, 'ton' => 'Head of Faculty / Department', 'ehq' => 'School Management', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 20, 'ton' => 'Middle School Teacher', 'ehq' => 'Teaching - Primary', 'seek' => 'seekAnz:jobCategory:seek:373m5CbdR'],
            ['position' => 21, 'ton' => 'Nurse / First Aid Officer', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 22, 'ton' => 'OSHC', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 23, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 24, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 25, 'ton' => 'Primary Teacher', 'ehq' => 'Teaching - Primary', 'seek' => 'seekAnz:jobCategory:seek:373m5CbdR'],
            ['position' => 26, 'ton' => 'Principal / Head of School', 'ehq' => 'School Management', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 27, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 28, 'ton' => 'Secondary Teacher', 'ehq' => 'Teaching - Secondary', 'seek' => 'seekAnz:jobCategory:seek:37YeFH6A3'],
            ['position' => 29, 'ton' => 'Deputy / Assistant Head of School', 'ehq' => 'School Management', 'seek' => 'seekAnz:jobCategory:seek:33Zarf9w5'],
            ['position' => 30, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:373m5CbdR'],
            ['position' => 31, 'ton' => 'Laboratory Technician', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 32, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:3A347fYo9'],
            ['position' => 33, 'ton' => 'Admin / SSO / Non-Teaching', 'ehq' => 'Non-Teaching Positions/Roles', 'seek' => 'seekAnz:jobCategory:seek:393HmWZju'],

        ];

        $posCtr = 0;
        foreach($position_types as $position_type) {
            $position = PositionType::create( [
                'name' => $position_type,
            ] );

            PositionMap::create([
                'position_type_id' => $position->id,
                'ehq' => $positionMap[$posCtr]['ehq'],
                'seek' => $positionMap[$posCtr]['seek']
            ]);

            $posCtr++;
        }

        $sectors = [
            'Catholic',
            'Independent',
            'International',
            'Government',
        ];

        foreach($sectors as $sector) {
            Sector::create( [
                'name' => $sector,
            ] );
        }

        $position_titles = [
            'Teacher',
            'Principal',
            'Assistant Principal',
            'Head of Department',
            'Head of School',
        ];

        foreach( $position_titles as $position_title ) {
            PositionTitle::create( [
                'name' => $position_title,
            ] );
        }

        //SChool Types
        $school_types = [
            'Combined (P-12)',
            'Primary (P-6)',
            'Secondary (7-12)',
            'Tertiary',
            'Early Childhood'
        ];

        foreach( $school_types as $school_type ) {
            SchoolType::create( [
                'name' => $school_type,
            ] );
        }

        //Religions
        $religions = [
            'Anglican',
            'Adventist',
            'Baptist',
            'Brethren',
            'Buddhist',
            'Catholic',
            'Christian',
            'Greek Orthodox',
            'Hare Krishna',
            'Hinduism',
            'Islamic',
            'Jewish',
            'Lutheran',
            'Muslim',
            'Non-denominational',
            'Orthodox',
            'Other',
            'Presbyterian & reformed',
            'Scientology',
            'Seventh Day Adventist',
            'Uniting Church'
        ];

        foreach( $religions as $religion ) {
            Religion::create( [
                'name' => $religion,
            ] );
        }


        //Curricula
        $curricula = [
            'Early Years',
            'Australian',
            'IB - PYP',
            'IB - MYP',
            'IB',
            'IBDP',
            'Montessori',
            'National Australian Steiner',
            'NSW',
            'NT',
            'QLD',
            'SA',
            'TAS',
            'TER',
            'VIC',
            'WA'
        ];

        foreach( $curricula as $curriculum ) {
            Curriculum::create( [
                'name' => $curriculum,
            ] );
        }

        //School Genders
        $genders = [
            'All Girls',
            'All Boys',
            'Coeducational'
        ];

        foreach( $genders as $gender ) {
            SchoolGender::create( [
                'name' => $gender,
            ] );
        }

    }
}