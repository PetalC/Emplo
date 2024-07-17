<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class TRBWARegistration
{

    public static function search( int $registration_number, $first_name, $last_name ) {

        /**
         *  WA Does not allow forms to be posted to from external sources. At this time there is no way to automate this process.
         */

        $url = "https://login.trb.wa.gov.au/Register-of-Teachers";

        return false;

    }

}
