<?php

namespace App\Job\Commands;

use Illuminate\Console\Command;
use App\Alert\Commands\SaveAlertCommand;
use App\Job\Models\Advert;
use App\School\Models\Profile;
use App\Alert\Models\Message;

use Carbon\Carbon;
use Validator;

/**
 * Creates a Job
 */
class CheckExpiringCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:check-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the Jobs Expiring';
    
    /** @var array */
    protected $messages;
    
    /**
     * Creates a new Command instance
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->messages = [];
    }
    
    /**
     * Main Processing to handle the Command
     * 
     * @return Response
     */
    public function handle()
    {
        $this->info('================= Initiate Checking ==================', "\n");

        if (!$this->validate()) {
            return false;
        }
        
        try {
            $dateYesterday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
            $expiresAtDate = Carbon::now()->addDays(1)->format('Y-m-d H:i:s');
            $jobs = Advert::where('expires_at', '<=', $expiresAtDate)
                ->where('expires_at', '>', $dateYesterday)
                ->get();

            foreach ($jobs as $job) {
                $this->info('================= Processing Job '.$job->id.' ==================', "\n");

                /* Create a Notification */
                $school = Profile::find($job->school);
                $schoolAdministrator = $school->getSchoolAdministrator();

                $alert = new Message();
                $alert->user = $schoolAdministrator->id;
                $alert->classification = 'Jobs';
                $alert->link = \URL::To('jobs/'.$job->id);
                $alert->content = $job->title.' will expire on '.date('d M', strtotime($job->expires_at));

                $saveAlertCommand = new SaveAlertCommand($alert);
                $saveAlertCommand->handle();
            }


            $this->info('================= Terminating Job Check ==================', "\n");
            return true;
            
        } catch (\Exception $error) {
            $this->info('================= Error! '.$error->getMessage().' ==================', "\n");
            $this->messages = [$error->getMessage()];
            return false;
        }
    }
    
    /**
     * Validates the input
     * 
     * @return Response
     */
    private function validate()
    {
        return true;
    }
}
