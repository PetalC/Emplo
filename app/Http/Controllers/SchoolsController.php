<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\Job;
use Illuminate\Http\Request;

class SchoolsController extends Controller {

    public function __construct() {

        if( request()->route('campus' ) ){

            $campus = Campus::where( 'id', request()->route('campus') )->first();

            if( $campus && $campus->primary_profile ){
                $campus->primary_profile->setColors();
            }

        }

    }

    public function index(Request $request) {
        return view('schools');
    }

    public function view( Campus $campus ){
        return view('school_public.profile' )->with( [
            'campus' => $campus,
            'campus_profile' => $campus->primary_profile,
        ] );
    }

}
