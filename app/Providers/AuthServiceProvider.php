<?php

namespace App\Providers;

use App\Models\Campus;
use App\Models\CampusProfile;
use App\Models\Certification;
use App\Models\Job;
use App\Models\School;
use App\Policies\Nova\GeneralResourcePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $generalNovaModels = [
            Certification::class,
            School::class,
            Campus::class,
            CampusProfile::class,
            Job::class,
            Role::class
        ];
        foreach ($generalNovaModels as $modelClass) {
            Gate::policy($modelClass, GeneralResourcePolicy::class);
        }
    }
}
