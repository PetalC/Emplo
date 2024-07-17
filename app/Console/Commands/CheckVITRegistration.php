<?php

namespace App\Console\Commands;

use App\Services\QCTRegistration;
use App\Services\VITRegistration;
use Illuminate\Console\Command;

class CheckVITRegistration extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:check-vit-registration {registration_number} {first_name} {last_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick and dirty script to check VIT Registration';

    /**
     * Execute the console command.
     */
    public function handle() {

        $registration_number = $this->argument('registration_number');
        $first_name = $this->argument('first_name');
        $last_name = $this->argument('last_name');

        $this->info("Checking VIT Registration for {$registration_number} ({$first_name} {$last_name})");

        $result = VITRegistration::search( $registration_number, $first_name, $last_name );

        $this->info($result ? 'Registration Found' : 'Registration Not Found' );

    }

}
