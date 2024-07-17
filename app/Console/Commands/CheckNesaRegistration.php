<?php

namespace App\Console\Commands;

use App\Services\NESARegistration;
use App\Services\QCTRegistration;
use Illuminate\Console\Command;

class CheckNesaRegistration extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:check-nesa-registration {registration_number} {first_name} {last_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick and dirty script to check NESA Registration';

    /**
     * Execute the console command.
     */
    public function handle() {

        $registration_number = $this->argument('registration_number');
        $first_name = $this->argument('first_name');
        $last_name = $this->argument('last_name');

        $this->info("Checking NESA Registration for {$registration_number} ({$first_name} {$last_name})");

//        $nesa = new \App\Services\NESARegistration();

        $result = NESARegistration::search( $registration_number, $first_name, $last_name );

        $this->info($result ? 'Registration Found' : 'Registration Not Found' );

    }

}
