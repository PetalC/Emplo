<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolPolicy extends Controller
{
    //
    public function __invoke(Request $request)
    {
        return view('school_policy');
    }
}
