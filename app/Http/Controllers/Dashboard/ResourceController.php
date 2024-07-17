<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PlanFeatures;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller {

    public function __construct(){

        $this->middleware(function($request, $next) {
            $school = session()->get('current_school');

            if( ! $school->subscription ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            if( ! $school->hasFeature( PlanFeatures::RESOURCE_LIBRARY->value ) ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            return $next($request);

        });

    }
    function index (Request $request) {

        $school = session()->get('current_school');

        return view('school.resources.index', [
            'school' => $school
        ]);

    }

}
