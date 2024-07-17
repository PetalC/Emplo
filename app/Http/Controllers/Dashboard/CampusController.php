<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PlanFeatures;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CampusProfile;
use Illuminate\Http\Request;

class CampusController extends Controller {

    public function __construct() {

        if( request()->route('profile') ){

            $profile = CampusProfile::find( request()->route('profile') );

            if( $profile ){
                $profile->setColors();
            }

        }

        $this->middleware(function($request, $next) {
            $school = session()->get('current_school');

            if( ! $school->subscription ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            if( ! $school->hasFeature( PlanFeatures::EMPLOYER_PROFILE->value ) ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            return $next($request);

        });

    }

    public function index(){
        return view('school.campuses.index');
    }

    public function create(){
        return view('school.campuses.create');
    }

    public function edit( Campus $campus ){
        return view('school.campuses.edit')->with( [ 'campus' => $campus ] );
    }

    public function profiles( Campus $campus ){
        return view('school.campuses.profiles')->with( [ 'profiles' => $campus->profiles, 'campus' => $campus ] );
    }

    public function view_profile(){

        $campus = session()->get('current_campus');

        if( ! $campus ){
            return redirect()->route('school.campuses') ;
        }

        $profile = $campus->primary_profile;

        return view('school.campuses.edit_profile')->with( [ 'profile' => $profile, 'campus' => $campus ] );

    }

    public function create_profile( Campus $campus ){
        return view('school.campuses.create_profile')->with( [ 'campus' => $campus ] );
    }

}
