<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class NTTRBRegistration
{

    public static function search( int $registration_number ) {

        try {

            $url = "https://trbsearch.ntschools.net/results.aspx?trbno=" . $registration_number;

            $response = Http::asForm()->get( $url );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

            // Find the table rows within the table
            $tableRows = $dom->find('.body-content table tr');
            $regFound = false;

            // Ensure the results contain the registration number
            foreach ($tableRows as $row) {

                $columns = $row->find('td');

                if (count($columns) >= 2) {
                    $regNumber = trim($columns[1]->text);

                    // Check if the registration number matches
                    if ($regNumber == $registration_number) {
                       $regFound = true;
                    }
                }
            }

            return $regFound;

        } catch(\Exception $error) {
            return false;
        }

    }

}
