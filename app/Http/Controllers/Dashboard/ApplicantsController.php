<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\ApplicationStatuses;
use App\Enums\PlanFeatures;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApplicantsController extends Controller {

    public function __construct(){

        $this->middleware(function($request, $next) {
            $school = session()->get('current_school');

            if( ! $school->subscription ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            if( ! $school->hasFeature( PlanFeatures::ATS->value ) ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            return $next($request);
        });

    }

    public function index(){
        $school = session()->get('current_school');
        return view('school.applicants.index', [
            'school' => $school
        ]);
    }

    public function view_applicants( Job $job ){
        return view('school.applicants.view', [
            'job' => $job,
        ]);
    }

}
