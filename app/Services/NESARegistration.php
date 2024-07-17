<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class NESARegistration
{

    public static function search( int $registration_number, string $first_name, string $last_name ) {

        try {

            /**
             * Valid HTML at time of writing. First one with a positive result, second is a negative result.
             *
             *
             * <div id="result-wrapper">
             *     <p class="details">2 results for "Sally Smith"</p>
             *     <div id="teacher-block">
             *         <h3>Sally Smith</h3>
             *         Member status: Active<br>
             *         NESA account number: 188317
             *     </div>
             *     <div id="teacher-block">
             *         <h3>Sally Smith</h3>
             *         Member status: Active<br>
             *         NESA account number: 257248
             *     </div>
             *     <hr class="dashed">
             * </div>
             *
             * <div id="result-wrapper">
             *     <p class="details">
             *         Teacher not found
             *     </p>
             *     <hr class="dashed">
             *     <b>Didn't find what you are looking for?</b>
             *     <ul>
             *         <li>Check your spelling</li>
             *         <li>Enter both first and last name fields.</li>
             *     </ul>
             *     <b>Contact us</b>
             *     <p>Email: <a href="mailto:publicregister@nesa.nsw.edu.au">publicregister@nesa.nsw.edu.au</a></p>
             * </div>
             *
             */

            $url = "https://etams.nesa.nsw.edu.au/PublicRegisterSearch";

            $response = Http::asForm()->post( $url, [
                'SearchFirstName' => $first_name,
                'SearchLastName' => $last_name,
            ] );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

            $results = $dom->find('#result-wrapper')[0];

            $teacher_blocks = $results->find('#teacher-block');

            /**
             * If the results contain "#teacher-block" with the registration number, then the registration is valid.
             */
            $validated_number = false;

            foreach( $teacher_blocks as $teacher_block ) {
                if( str_contains( $teacher_block->text, $registration_number ) ) {
                    $validated_number = true;
                }
            }

            return $validated_number;

        } catch(\Exception $error) {
            return false;
        }

    }

}
