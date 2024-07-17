<?php

namespace App\Services;

use Carbon\Carbon;
use App\Job\Models\Advert;
use App\School\Models\Profile;

class TeachersOnNetRest
{
    const BASE_URL = 'https://hooks.zapier.com/hooks/catch/2917245/bvs295p';

    public function __construct()
    {

    }

    public function createJob($fields)
    {
        $url = self::BASE_URL;

        $headers = [
            'Content-type: application/json',
        ];

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

    private function _convertRecruitPositionType($position_type)
    {
        $zohoRecruitTypes = [
            'Secondary Teacher',
            'Finance and Payroll',
            'Support Position',
            'Boarding Staff',
            'Business/Finance Manager',
            'Canteen / Tuck Shop',
            'Chaplan',
            'Cleaners',
            'Coach',
            'Middle Management',
            'Senior Leadership',
            'Diverse Learning/Special Needs',
            'Kindergarten/Early Childhood',
            'Primary Teacher',
            'Head of Faculty/Department',
            'Technician',
            'Library/Information Services',
            'Marketing and Communications',
            'Middle School Teacher',
            'OSHC',
            'Administration',
            'Principal/Head of School',
            'Nurse/First Aid Officer',
        ];

        $tonTypes = [
            'Secondary Teacher',
            'Business / Finance Manager',
            'Admin / SSO / Non-Teaching',
            'Boarding Staff',
            'Business / Finance Manager',
            'Canteen',
            'Chaplains / Pastoral Care',
            'Cleaners',
            'Coach',
            'Head of Faculty / Department',
            'Deputy / Assistant Head of School',
            'All Grade Levels (P-12)',
            'Kindergarten / ELC / Early Childhood',
            'Primary Teacher',
            'Head of Faculty / Department',
            'Laboratory Technician',
            'Teacher Librarian',
            'Marketing Communications',
            'Middle School Teacher',
            'OSHC',
            'Admin / SSO / Non-Teaching',
            'Principal / Head of School',
            'Nurse / First Aid Officer',
        ];

        $idx = array_search($position_type, $zohoRecruitTypes);

        if ($idx !== FALSE) {
            return $tonTypes[$idx];
        }

        return 'Admin / SSO / Non-Teaching';
    }

}
