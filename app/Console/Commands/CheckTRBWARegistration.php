<?php

namespace App\Console\Commands;

use App\Services\QCTRegistration;
use App\Services\TRBSARegistration;
use App\Services\TRBTASRegistration;
use App\Services\TRBWARegistration;
use App\Services\VITRegistration;
use Illuminate\Console\Command;

class CheckTRBWARegistration extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:check-trbwa-registration {registration_number} {first_name} {last_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick and dirty script to check TRBWA Registration';

    /**
     * Execute the console command.
     */
    public function handle() {

        $registration_number = $this->argument('registration_number');
        $first_name = $this->argument('first_name');
        $last_name = $this->argument('last_name');

        $this->info("Checking TRBWA Registration for {$registration_number} ({$first_name} {$last_name})");

        $result = TRBWARegistration::search( (int)$registration_number, $first_name, $last_name );

        $this->info($result ? 'Registration Found' : 'Registration Not Found' );

    }

}
