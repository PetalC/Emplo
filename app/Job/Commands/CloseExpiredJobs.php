<?php

namespace App\Job\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobClosed;
use App\Alert\Commands\SaveAlertCommand;
use App\Job\Models\Advert;
use App\School\Models\Profile;
use App\Alert\Models\Message;

use Carbon\Carbon;
use Validator;

/**
 * Creates a Job
 */
class CloseExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:close-expired-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closes Jobs that are Expired';
    
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
        $this->info('================= Initiate Closing ==================', "\n");

        if (!$this->validate()) {
            return false;
        }
        
        try {
            $dateToday = Carbon::now()->format('Y-m-d H:i:s');
            $jobs = Advert::where('expires_at', '<', $dateToday)
                ->where('closed_at', NULL)
                ->get();

            foreach ($jobs as $job) {
                $this->info('================= Processing Job '.$job->id.' ==================', "\n");
                /* Closes the job */
                $job->closed_at = $dateToday;
                $job->save();
                $job->unsearchable();

                /* Create a Notification */
                $school = Profile::find($job->school);
                $schoolAdministrator = $school->getSchoolAdministrator();
                
                if (!$schoolAdministrator) {
                    continue;
                }

                $alert = new Message();
                $alert->user = $schoolAdministrator->id;
                $alert->classification = 'Jobs';
                $alert->link = \URL::To('jobs/'.$job->id);
                $alert->content = $job->title.' has expired and has been closed';

                $saveAlertCommand = new SaveAlertCommand($alert);
                $saveAlertCommand->handle();

                Mail::to($schoolAdministrator->email)
                    ->send(new JobClosed($job));
            }


            $this->info('================= Terminating Job Closing ==================', "\n");
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
