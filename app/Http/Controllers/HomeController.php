<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        return redirect( route( 'candidates' ), 302 );

//        return view('home');
    }

}
