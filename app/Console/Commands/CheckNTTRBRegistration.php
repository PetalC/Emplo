<?php

namespace App\Console\Commands;

use App\Services\NTTRBRegistration;
use App\Services\QCTRegistration;
use Illuminate\Console\Command;

class CheckNTTRBRegistration extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:check-nttrb-registration {registration_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick and dirty script to check NTTRB Registration';

    /**
     * Execute the console command.
     */
    public function handle() {

        $registration_number = $this->argument('registration_number');

        $this->info("Checking NTTRB Registration for {$registration_number}");

        $qct = new \App\Services\NTTRBRegistration();

        $result = NTTRBRegistration::search( $registration_number );

        $this->info($result ? 'Registration Found' : 'Registration Not Found' );

    }

}
