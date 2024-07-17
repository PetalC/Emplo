<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;

class TRBSARegistration
{

    public static function search( int $registration_number, $first_name, $last_name ) {

        try {

            /**
             * Valid HTML at time of writing. First one with a negative result, second is a positive result.
             *
             * <div class="grid-mvc" data-lang="en" data-gridname="" data-selectable="true" data-multiplefilters="false">
             *     <div class="grid-wrap">
             *         <table class="table table-striped grid-table">
             *             <tbody>
             *                 <tr class="grid-empty-text">
             *                     <td colspan="7">
             *                         There are no items to display
             *                     </td>
             *                 </tr>
             *             </tbody>
             *         </table>
             *     </div>
             * </div>
             *
             * <div class="grid-mvc" data-lang="en" data-gridname="" data-selectable="true" data-multiplefilters="false">
             *     <div class="grid-wrap">
             *         <table class="table table-striped grid-table">
             *            thead etc here, but irrelevant for this script
             *            <tbody>
             *                <tr class="grid-row ">
             *                    <td class="grid-cell wrapped" data-name="FirstName">Aaron Jay</td>
             *                    <td class="grid-cell wrapped" data-name="LastName">Smith</td>
             *                    <td class="grid-cell wrapped" data-name="Regnumber">599732</td>
             *                    <td class="grid-cell wrapped" data-name="RegistrationCategory">Full Registration</td>
             *                    <td class="grid-cell wrapped" data-name="Status">Current</td>
             *                    <td class="grid-cell wrapped" data-name="Annotation"></td>
             *                    <td class="grid-cell wrapped" data-name="RegExpiryDate">1/02/2027</td>
             *                </tr>
             *            </tbody>
             *        </table>
             *    </div>
             * </div>
             */

            $url = "https://crmpub.trb.sa.edu.au/Home/TeacherSearch";

            $response = Http::asForm()->post( $url, [
                'givenname' => $first_name,
                'surname' => $last_name,
                'regnumber' => $registration_number
            ] );

            if ( $response->failed() ) {
                return false;
            }

            $dom = new Dom();

            $dom->loadStr( $response->body() );

            $grid_row = $dom->find('.grid-mvc .grid-row')[0];

            if ( ! $grid_row ) {
                return false;
            }

            $rows = $grid_row->find('td.grid-cell');

//            $rows[0];// First Name
//            $rows[1];// Last Name
//            $rows[2];// Registration Number

            if( count( $rows ) < 3 ) {
                return false;
            }

            if(
                str_contains( $rows[0]->text, $first_name ) &&
                str_contains( $rows[1]->text, $last_name ) &&
                str_contains( $rows[2]->text, $registration_number )
            ) {
                return true;
            }

        } catch(\Exception $error) {
            return false;
        }

    }

}
