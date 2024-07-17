<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class QCTRegistration
{

    public static function search( int $registration_number ) {

        try {

            $url = "https://www.qct.edu.au/registersearch";

            $response = Http::asForm()->post( $url, [
                'RegNo' => $registration_number
            ] );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

            $results = $dom->find('#search-results .row')[0];

            $children = $results->find( '.col-xs-12' )->count();

//            dump( $registration_number, $children );

            /**
             * Valid HTML at time of writing. First one with a negative result, second is a positive result.
             *
             * Load #search_results .row
             * Count the number of children with a class of .col-xs-12 if more than one its a positive result.
             *
             * <div id="search-results">
             *      <div class="row">
             *          <div class="col-xs-12">
             *              <div class="data-title">There are no matching approved teachers for this search.</div>
             *              <div class="data-title">Please check your entry and try again.</div>
             *          </div>
             *      </div>
             * </div>
             *
             * <div id="search-results">
             *  <div class="row ">
             *      <div class="col-xs-12 col-sm-4">
             *          <div class="name">AARJON ANNETTE SMITH</div>
             *      </div>
             *      <div class="col-xs-12 col-sm-2">
             *          <div class="data-title hidden-sm hidden-md hidden-lg col-xs-6">Registration number:</div>
             *          <div class="search-data col-xs-6 col-md-12">771126</div>
             *      </div>
             *      <div class="col-xs-12 col-sm-2">
             *          <div class="data-title hidden-sm hidden-md hidden-lg col-xs-6">Registration status:</div>
             *          <div class="search-data col-xs-6 col-md-12">Full</div>
             *      </div>
             *      <div class="col-xs-12 col-sm-2">
             *          <div class="data-title hidden-sm hidden-md hidden-lg col-xs-6">Annual fee due: </div>
             *          <div class="search-data col-xs-6 col-md-12">31/12/2024</div>
             *      </div>
             *      <div class="col-xs-12 col-sm-2">
             *          <div class="data-title hidden-sm hidden-md hidden-lg col-xs-6">Registration renewal/end:</div>
             *          <div class="search-data col-xs-6 col-md-12">31/12/2025</div>
             *      </div>
             *  </div>
             * </div>
             */

            return $children > 1;

        } catch(\Exception $error) {
            return false;
        }

    }

}
