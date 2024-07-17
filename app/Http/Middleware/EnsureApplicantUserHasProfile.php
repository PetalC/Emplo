<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicantUserHasProfile {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if( $request->user() && $request->user()->can( 'jobseeker.all' ) ){
            $request->user()->profile()->firstOrCreate( [
                'user_id' => $request->user()->id
            ] );
        }

        return $next($request);

    }

}
