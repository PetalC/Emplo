<?php

namespace App\Console\Commands;

use App\Models\Campus;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallUuids extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:create-uuids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle() {

        $jobs = Job::query()->whereNull('uuid')->get();

        foreach( $jobs as $job ){
            $job->uuid = Str::uuid();
            $job->save();
        }

        $campuses = Campus::query()->whereNull('uuid')->get();

        foreach( $campuses as $campus ){
            $campus->uuid = Str::uuid();
            $campus->save();
        }

    }

}
