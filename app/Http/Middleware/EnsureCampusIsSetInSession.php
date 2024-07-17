<?php

namespace App\Http\Middleware;

use App\Models\Campus;
use App\Models\Job;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureCampusIsSetInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if( ! auth()->check() ){
            return redirect()->route('auth' );
        }

        /**
         * @var User $user
         */
        $user = auth()->user();

        if( $user->can( 'school.view-dashboard' ) ){

            $count = $user->schools->count();

            if( $count == 1 ){

                $school = $user->schools->first();
                Session::put( 'current_school', $school );

                $campus_count = $school->campuses->count();

                if( $campus_count === 1 ){
                    Session::put( 'current_campus', $school->campuses->first() );
                }

            } else {

                if( ! session()->has('current_school') && ! request()->routeIs( 'school.select_school') ){
                    return redirect()->route('school.select_school');
                }

                if( ! session()->has('current_campus' ) && ! request()->routeIs( 'school.campuses')  ){
                    return redirect()->route('school.campuses' );
                }

            }

        }

        /**
         * We have the appropriate session variables. We can add the global scopes for Jobs, Campuses etc here.
         */
        Campus::addGlobalScope('school', function ($query) {
            if( session()->has('current_school') ){
                $query->where('school_id', session()->get('current_school')->id );
            }
        });

        Job::addGlobalScope('campus', function ($query) {
            if( session()->has('current_campus') ){
                $query->where('campus_id', session()->get('current_campus')->id );
            }
        });


        return $next($request);

    }
}
