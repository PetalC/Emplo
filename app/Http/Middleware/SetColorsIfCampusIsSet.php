<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetColorsIfCampusIsSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $campus = session()->get('current_campus');

        if( $campus && $campus->primary_profile ){
            $campus->primary_profile->setColors();
        }

        return $next($request);
    }
}
