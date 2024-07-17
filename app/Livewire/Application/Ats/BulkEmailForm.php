<?php

namespace App\Livewire\Application\Ats;

use App\Enums\MediaCollections;
use App\Facades\EmailTemplateFacade;
use App\Mail\Application\External\ApplicantCustomEmail;
use App\Models\Application;
use App\Models\EmailTemplate;
use App\Models\School;
use App\Traits\HasEmailTemplateOptions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class BulkEmailForm extends Component {

    use HasEmailTemplateOptions;

//    #[Reactive]
    #[Modelable]
    public array $selected_applicants;

    public array $selected_emails = [];
    public array $email_details = [];

    public bool $email_sent = false;

    public function mount() {

        $this->email_details = [
            'subject' => 'Email Subject',
            'message' => 'Hi Candidate, please give us some more information',
        ];
        $this->loadEmailTemplates();
    }

    public function sendEmail() {

        $subject = $this->email_details['subject'];
        $message = $this->email_details['message'];

        foreach ($this->selected_emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                Mail::to($email)->send(new ApplicantCustomEmail($subject, $message));
            }
        }

        $this->email_sent = true;

        $this->render();

    }

    public function updating($property, $value) {
        // Normalize the field name and get the index and key if available
        $fieldParts = explode('.', $property);
        $index = $fieldParts[0];
        $key = $fieldParts[1] ?? null;

        if ($index == 'email_details') {
//            dd($property, $value, $key);
//            if ($key == 'template') {
//                // Template has changed
//                $this->email_details['message'] = $this->email_template_data[$this->email_template_options[$value]];
//            }
        }

    }
    public function render() {

        $this->selected_emails = [];

        foreach( $this->selected_applicants as $id => $emailing ){
            if( ! $emailing ){
                continue;
            }
            $application = Application::find($id);
            if( $application ){
                $this->selected_emails[] = $application->user->email;
            }
        }
        return view('livewire.application.ats.bulk-email-form');

    }

}
