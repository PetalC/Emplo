<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class VITRegistration
{

    public static function search( int $registration_number, string $first_name, string $last_name ) {

        try {

            /**
             * Valid HTML at time of writing. First one with a positive result, second is a negative result.
             *
             *
             * <div class="results-block">
             *     <p class="results-block__result">
             *         10 results for “Sam Smith”
             *     </p>
             *
             *     <ul class="results-block__list">
             *         <li class="">
             *             <p class="results-block__title">Samantha Smith</p>
             *             <p class="results-block__registration">Registration number: 602999</p>
             *             <p class="results-block__registrationtype">Registered Teacher</p>
             *
             *             <p class="results-block__others">
             *                 <small>Initial registration date: </small>
             *                 <small>06/12/2017</small>
             *             </p>
             *             <p class="results-block__others">
             *                 <small>Expiry date: </small>
             *                 <small>30/09/2024</small>
             *             </p>
             *         </li>
             *     </ul>
             * </div>
             *
             * <div class="results-block">
             *     <p class="results-block__result">
             *         0 results for “546987”
             *     </p>
             * </div>
             *
             */

            $url = "https://www.vit.vic.edu.au/search-the-register";

            $response = Http::asForm()->get( $url, [
                'firstname' => $first_name,
                'lastname' => $last_name,
                'registrationnumber' => $registration_number,
            ] );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

            $found_items = $dom->find('.results-block__list li');

            $validated_number = false;

            foreach( $found_items as $found_item ) {
                // Have to validate all 3 here as the search results seem to run an OR query not an AND query,
                // so searching for Laura Smith 600081 which should be false (Laura Smith 600080 is valid) will return a result for Skye Frances Brennan 600081.
                if(
                    str_contains( $found_item->find('.results-block__registration')[0]->text, $registration_number ) &&
                    str_contains( $found_item->find('.results-block__title')[0]->text, $first_name ) &&
                    str_contains( $found_item->find('.results-block__title')[0]->text, $last_name )
                ) {
                    $validated_number = true;
                }
            }

            return $validated_number;

        } catch(\Exception $error) {
            return false;
        }

    }

}
