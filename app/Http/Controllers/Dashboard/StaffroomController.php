<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PlanFeatures;
use App\Http\Controllers\Controller;
use App\Mail\StaffroomFollowersEmail;
use App\Models\School;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StaffroomController extends Controller
{

    public function __construct(){

        $this->middleware(function($request, $next) {
            $school = session()->get('current_school');

//            dd( $school->subscription );

            if( ! $school->subscription ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            if( ! $school->hasFeature( PlanFeatures::STAFF_ROOM->value ) ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            return $next($request);
        });

    }

    public function candidates_index(){

        $campus = session()->get('current_campus');

        return view('school.staffroom.index', [
            'campus' => $campus
        ] );
    }

    public function send_email(Request $request)
    {
        try {
            $title = $request->input('title', '');
            $content = $request->input('content', '');
            $emails = explode(',', $request->input('emails', ''));

            foreach ($emails as $email) {
                $email = trim($email);
                if (!empty($email)) {
                    Mail::to($email)->send(new StaffroomFollowersEmail($title, $content));
                }
            }

            return response()->json([
                "message" => 'Email(s) sent successfully',
                "resource" => []
            ]);
        } catch (Exception $error) {
            return response()->json([
                "message" => 'Error sending email(s): ' . $error->getMessage(),
                "resource" => []
            ], 500);
        }
    }

}
