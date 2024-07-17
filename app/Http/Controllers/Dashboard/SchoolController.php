<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;

class SchoolController extends Controller {

    public function index(){

        //implementation of auth user role
        return view('school.select_school' );

    }

}
