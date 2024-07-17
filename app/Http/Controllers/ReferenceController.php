<?php

namespace App\Http\Controllers;

use App\Enums\PlanFeatures;
use App\Models\Application;
use App\Models\CampusProfile;
use App\Models\Job;
use App\Models\ReferenceCheck;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ReferenceController extends Controller
{

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

    /**
     * Handle the incoming request.
     */
    public function view(ReferenceCheck $referenceCheck)
    {
        return view('reference.index', [
            'referenceCheck' => $referenceCheck,
        ]);
    }

    /**
     * nominate references for an application
     */
    public function nominate(Application $application)
    {
//        dd($application);
        return view('reference.nominate-form', [
            'application' => $application
        ]);
    }
}
