<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller {

    /**
     * Handle the incoming request.
     */
//    public function index(Request $request) {
//        return view('auth.index');
//    }

    public function reset_password(){
        return view('auth.reset_password');
    }

    public function verify_email(){
        return view('auth.verify_email');
    }


}
