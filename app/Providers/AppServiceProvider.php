<?php

namespace App\Providers;

use App\Services\EmailTemplate;
use App\Services\Mapbox;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {

        $this->app->bind('mapbox',function(){
            return new Mapbox();
        });

        $this->app->bind('email_template',function(){
            return new EmailTemplate();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
    }

}
