<?php

namespace App\Livewire\Application\Ats;

use App\Enums\SystemEmailTypes;
use App\Mail\Application\External\ApplicantCustomEmail;
use App\Mail\Application\External\ApplicantRequestReferencesEmail;
use App\Models\Application;
use App\Models\EmailTemplate;
use App\Traits\HasEmailTemplateOptions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EmailForm extends Component
{

    use HasEmailTemplateOptions;
    const EVENT_SUBMITTED = 'submitted-email-form';

    #[Locked]
    public Application $application;

    public array $email_details = [];

    /**
     * @var string Specified to allow system to be aware of which type of email was sent
     */
    public string $email_type = SystemEmailTypes::GENERIC->value;

    public bool $email_sent = false;

    public function mount(Application $application)
    {
        $this->application = $application;
        $this->email_details = [
            'subject' => 'Prefilled email subject',
            'message' => 'Hi Candidate, please give us some more information',
        ];
        $this->loadEmailTemplates();
    }

    /**
     * Pre-defined data in the email form
     * TODO: need to load the same email form across the board and change the data based on what's being viewed
     *  (bulk, hired candidate confirmation, table item email form etc)
     *  Otherwise there is no valid key and we can't set the data from the template :(
     * @param $type
     * @return void
     */
//    #[On('predefined-email')]
//    public function predefineEmailSet($type) {
//        dd($type);
//        if ($type == 'reference-request') {
//            $this->email_details['subject'] = 'References Requested';
//            $this->email_details['message'] = 'Please provide references for your application as we\'d like to consider you further.';
//        }
//    }

    public function sendEmail() {
        $subject = $this->email_details['subject'];
        $message = $this->email_details['message'];

        $emails = [
            $this->application->user->email
        ];
        foreach ($emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                $this->_sendEmail($email, $subject, $message);
            }
        }
        $this->dispatch(self::EVENT_SUBMITTED, $this->email_type, $this->application->id);

    }

        public function render()
    {
        return view('livewire.application.ats.email-form');
    }

    private function _sendEmail(string $email, mixed $subject, mixed $message)
    {
        if ($this->email_type == SystemEmailTypes::GENERIC->value) {
            Mail::to($email)->send(new ApplicantCustomEmail($subject, $message));
        }
        if ($this->email_type == SystemEmailTypes::REQUEST_REFERENCES->value) {
            $nominateReferenceUrl = route('school.applicants.references.nominate', $this->application);
            Mail::to($email)->send(new ApplicantRequestReferencesEmail($subject, $message, $nominateReferenceUrl));
        }

    }
}
