<?php

namespace App\Console\Commands;

use App\Services\QCTRegistration;
use Illuminate\Console\Command;

class CheckQctRegistration extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:check-qct-registration {registration_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick and dirty script to check QCT Registration';

    /**
     * Execute the console command.
     */
    public function handle() {

        $registration_number = $this->argument('registration_number');

        $this->info("Checking QCT Registration for {$registration_number}");

        $qct = new \App\Services\QCTRegistration();

        $result = QCTRegistration::search( $registration_number );

        $this->info($result ? 'Registration Found' : 'Registration Not Found' );

    }

}
