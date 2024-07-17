<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller {

    public function __construct() {
        Job::withoutGlobalScope('campus');
    }

    /**
     * Handle the incoming request.
     */
    public function index(Request $request) {
        return view('search');
    }

}
