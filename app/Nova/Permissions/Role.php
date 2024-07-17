<?php

namespace App\Nova\Permissions;

use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Control data so a Super Admin (basic nova user) can not see breakable things
 */
class Role extends \Vyuldashev\NovaPermission\Role
{
    public function fields(NovaRequest $request)
    {
        $fields = parent::fields($request);
        $modifiedFields = [];
        foreach ($fields as $field) {
            switch($field->attribute) {
                case 'guard_name':
                    $field->canSee(fn (NovaRequest $request) => $request->user()->can('developer.super') || env('APP_ENV') === 'local');
                    break;
                case 'permissions':
                    $field->canSee(fn (NovaRequest $request) => $request->user()->can('developer.super') || env('APP_ENV') === 'local');
                    break;
            }
            $modifiedFields[] = $field;
        }
        return $modifiedFields;
    }

}
