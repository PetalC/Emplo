<?php

namespace App\Job\Commands;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Core\SystemCommand;
use App\Mail\CandidateApplication;
use App\Mail\JobApplication;
use App\Alert\Commands\SaveAlertCommand;
use App\User;
use App\Job\Models\Advert;
use App\School\Models\Profile;
use App\Alert\Models\Message;

use Validator;

/**
 * User Applies to a Job
 */
class JobApplicationCommand extends SystemCommand
{
    /** @var User */
    protected $user;
    
    /** @var Advert */
    protected $advert;
    
    /**
     * Initialize the Class
     * 
     * @param User $user
     * @param Advert $advert
     */
    public function __construct(User $user, Advert $advert)
    {
        $this->user = $user;
        $this->advert = $advert;
    }
    
    /**
     * Main Processing to handle the Command
     * 
     * @return boolean
     */
    public function handle()
    {
        if (!$this->validate()) {
            return false;
        }
        
        try {
            $this->advert->candidates()->attach($this->user,[
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $school = Profile::find($this->advert->school);
            $schoolAdministrator = $school->getSchoolAdministrator();

            /* Create notification */
            $message = new Message();
            $message->user = $schoolAdministrator->id;
            $message->classification = 'Jobs';
            $message->link = \URL::To('jobs/'.$this->advert->id);
            $message->content = "Candidate ".$this->user->name." has applied for ".$this->advert->title." position";
            
            $saveAlertCommand = new SaveAlertCommand($message);
            $saveAlertCommand->handle();

            /* Send Emails */
            Mail::to($schoolAdministrator->email)
                ->send(new CandidateApplication($this->user, $this->advert));
            
            Mail::to($this->user->email)
                ->send(new JobApplication($this->user, $this->advert));

            return true;
            
        } catch (\Exception $error) {
            $this->setMessages([$error->getMessage()]);
            return false;
        }
    }
    
    /**
     * Validates the input
     * 
     * @return boolean
     */
    private function validate()
    {
        return true;
    }
}
