<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void {

        if( env('APP_ENV') === 'production' ) {
            $schedule->command('school:import-crm-schools --modified-only')->everyTwoMinutes()->evenInMaintenanceMode();

            // This can be removed once all the logos have been processed
//            $schedule->command('emplo:process-campus-logos')->everyTwoMinutes()->evenInMaintenanceMode()->emailOutputTo( 'ben.casey@humanpixel.com.au' );
        }

//        $schedule->command('emplo:process-latitude-longitude' )->everyMinute()->storeOutput()->evenInMaintenanceMode();

//        $schedule->command('backup:clean')->daily()->at('01:00')->evenInMaintenanceMode();
//        $schedule->command('backup:run')->daily()->at('01:30')->evenInMaintenanceMode();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
