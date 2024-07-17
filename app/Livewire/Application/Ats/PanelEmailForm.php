<?php

namespace App\Livewire\Application\Ats;

use App\Mail\Application\External\ApplicantCustomEmail;
use App\Mail\Application\Internal\PanelCustomEmail;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Locked;
use Livewire\Component;

class PanelEmailForm extends Component {

    #[Locked]
    public Job $job;

    public array $email_details = [];

    public array $emails = [];

    public $email_sent = false;

    public function mount() {
        $this->email_details = [
            'subject' => 'Prefilled email subject',
            'message' => 'Hi Panel Member, please give us some more information',
        ];

        $panel_members = $this->job->panel_members;

        foreach ($panel_members as $panel_member) {
            if( $panel_member->email ){
                $this->emails[] = $panel_member->email;
            }
        }

    }

    public function sendEmail() {
        $subject = $this->email_details['subject'];
        $message = $this->email_details['message'];

        foreach ($this->emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                Mail::to($email)->send(new PanelCustomEmail($subject, $message));
            }
        }

        $this->email_sent = true;

        $this->render();

    }

    public function render() {
        return view('livewire.application.ats.panel-email-form');
    }

}
