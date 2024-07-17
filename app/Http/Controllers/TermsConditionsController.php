<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function candidates(Request $request) {
        return view('terms_and_conditions');
    }

    public function employer(Request $request) {
        return view('terms_and_conditions_employer' );
    }

}
