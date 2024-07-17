<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PlanFeatures;
use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {

        /**
         * @var School $school
         */
        $school = Session::get('current_school');

        if( ! $school->subscription ) {
            return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
        }

        if( ! $school->hasFeature( PlanFeatures::DASHBOARD->value ) ) {
            return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
        }

        $schoolDetails = json_decode(session()->get('current_school'));

        return view('school.dashboard')->with('schoolDetails',$schoolDetails);
    }
}
