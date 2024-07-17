<?php

namespace App\Providers;

use App\Nova\Campus;
use App\Nova\CampusProfile;
use App\Nova\Certification;
use App\Nova\CitizenshipType;
use App\Nova\Curriculum;
use App\Nova\Dashboards\Main;
use App\Nova\Feature;
use App\Nova\Gender;
use App\Nova\Job;
use App\Nova\JobLength;
use App\Nova\LocationType;
use App\Nova\Plan;
use App\Nova\PositionTitle;
use App\Nova\PositionType;
use App\Nova\Religion;
use App\Nova\School;
use App\Nova\SchoolType;
use App\Nova\Sector;
use App\Nova\State;
use App\Nova\Subject;
use App\Nova\Subscriptions;
use App\Nova\User;
use App\Policies\Nova\PermissionPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use LucasDotVin\Soulbscription\Models\Subscription;
use Vyuldashev\NovaPermission\NovaPermissionTool;
use Vyuldashev\NovaPermission\Permission;
use Vyuldashev\NovaPermission\Role;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),


                MenuSection::make( 'Plans', [
                    MenuItem::resource(Plan::class),
                    MenuItem::resource(Feature::class),
                    MenuItem::resource(Subscriptions::class),
                ] )->icon('credit-card')->collapsable()
                    ->canSee(fn (NovaRequest $request) => $request->user()->can('developer.super')),

                MenuSection::make( 'Users', [
                    MenuItem::resource(User::class), // anyone with access to nova should be able to edit users
                    MenuItem::resource(Role::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),
                    MenuItem::resource(Permission::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('developer.super') || env('APP_ENV') === 'local'),
                    MenuItem::resource(Certification::class)
                ])->icon('user')->collapsable()
                    ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),

                MenuSection::make( 'Schools', [
                    MenuItem::resource(School::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),
                    MenuItem::resource(Campus::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),
                    MenuItem::resource(CampusProfile::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),
                ])->icon('academic-cap')->collapsable(),

                MenuSection::make( 'Jobs', [
                    MenuItem::resource(Job::class)
                        ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),
                ])->icon('briefcase')->collapsable()
                    ->canSee(fn (NovaRequest $request) => $request->user()->can('nova.manage.general')),

                MenuSection::make( 'Taxonomies', [
                    MenuItem::resource(JobLength::class),
                    MenuItem::resource(LocationType::class),
                    MenuItem::resource(PositionType::class),
                    MenuItem::resource(Sector::class),
                    MenuItem::resource(Subject::class),
                    MenuItem::resource(PositionTitle::class),
                    MenuItem::resource(Curriculum::class),
                    MenuItem::resource(Gender::class),
                    MenuItem::resource(Religion::class),
                    MenuItem::resource(SchoolType::class),
                    MenuItem::resource(CitizenshipType::class),
                    MenuItem::resource(State::class),
                ])->icon('tag')->collapsable()
                    ->canSee(function (NovaRequest $request) {
                        return $request->user()->can('nova.manage.taxonomies');
                    }),

            ];
        });

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->can('nova.view');
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        $novaPermissionTool = NovaPermissionTool::make();
        // Override the nova permissions policies
        $novaPermissionTool->permissionPolicy = PermissionPolicy::class;
//        $novaPermissionTool->rolePolicy = RolePolicy::class; // Only want to control permissions
        return [
//            new \Spatie\BackupTool\BackupTool(),
            $novaPermissionTool
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
