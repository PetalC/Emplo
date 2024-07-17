<?php

namespace App\Traits;

/**
 * Control parts of the app that super users can't access
 */
trait HasDeveloperPermissions
{
    protected function isDeveloperUser()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return ($user->can('developer.super') || (env('APP_ENV') === 'local'));
    }

}
