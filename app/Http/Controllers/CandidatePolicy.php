<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidatePolicy extends Controller
{
    //
    public function __invoke(Request $request)
    {
        return view('candidate_policy');
    }
}
