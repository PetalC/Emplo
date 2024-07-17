<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SlugifyJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emplo:slugify-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $jobs = Job::all();

        foreach ($jobs as $job) {
            $job->url_slug = Str::slug($job->title);
            $job->save();
        }

    }
}
