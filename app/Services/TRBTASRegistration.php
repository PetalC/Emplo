<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class TRBTASRegistration
{

    public static function search( int $registration_number, $first_name, $last_name ) {

        try {

            /**
             * Valid HTML at time of writing. First one with a negative result, second is a positive result.
             *
             * <div id="teacherSearch" style="">
             *     <h2 class="search">This is an extract of the Register of Teachers</h2>
             *
             *     <div class="center">
             *         No currently registered teachers could be found for the details you specified
             *     </div>
             * </div>
             *
             * <div id="teacherSearch" style="display: block;">
             *     <h2 class="search">This is an extract of the Register of Teachers</h2>
             *     <table>
             *         <tbody>
             *             <tr class="head">
             *                 <th>TRB #</th>
             *                 <th>Last Name</th>
             *                 <th>First Name</th>
             *                 <th>Middle Name</th>
             *                 <th>Registration Type</th>
             *                 <th>Registered Until</th>
             *             </tr>
             *             <tr class="odd">
             *                 <td>31677</td>
             *                 <td>Smith</td>
             *                 <td>Jessie-Ellen</td>
             *                 <td></td>
             *                 <td>Provisional Registration</td>
             *                 <td>31/12/2024</td>
             *            </tr>
             *         </tbody>
             *     </table>
             * </div>
             */

            $url = "https://trbonline.trb.tas.gov.au/Teacher/Search";

            $response = Http::asForm()->post( $url, [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'trs_trbnumber' => $registration_number
            ] );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

//            dd( $response->body() );

            $grid_row = $dom->find('tr.odd')[0];

//            dd( $grid_row );

            if ( ! $grid_row ) {
                return false;
            }

            $rows = $grid_row->find('td');

//            $rows[0];// Registration Number
//            $rows[1];// Surname
//            $rows[2];// First Name

            if( count( $rows ) < 3 ) {
                return false;
            }

            if(
                str_contains( $rows[0]->text, (string)$registration_number ) &&
                str_contains( $rows[1]->text, $last_name ) &&
                str_contains( $rows[2]->text, $first_name )
            ) {
                return true;
            }

        } catch(\Exception $error) {
            return false;
        }

    }

}
