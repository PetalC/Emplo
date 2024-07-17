<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Permission\Models\Role;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Users';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Vyuldashev\NovaPermission\Permission::class),
            BelongsToMany::make('Schools', 'schools', School::class )->searchable(),

//            BelongsToMany::make('Specializations', 'subjects', School::class ),

            HasMany::make('Specializations', 'subjects', Subject::class )->sortable(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Developer permissions can see other developers, anyone else will not know about it
     * aka: super secret squirrel business
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->can('developer.super')) {
            return $query;
        }

        $devRoleId = Role::where('name', 'Developer')->first()->id;
        $developerUserIds = DB::query()
            ->select('model_id')
            ->from(config('permission.table_names.model_has_roles'))
            ->where('model_type', '=', "App\\Models\\User")
            ->where('role_id', $devRoleId);

        return $query->whereNotIn('id', $developerUserIds->get()->pluck('model_id')->toArray());
    }
    /**
     * Developer permissions can add other developers, anyone else will not know about the developer role
     * aka: super secret squirrel business
     */
    public static function relatableRoles(NovaRequest $request, $query)
    {
        if ($request->user()->can('developer.super')) {
            return $query;
        }
        return $query->where('name', '!=', 'Developer');
    }
}
