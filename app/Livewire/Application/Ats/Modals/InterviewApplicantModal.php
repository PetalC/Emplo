<?php

namespace App\Livewire\Application\Ats\Modals;

use App\Enums\ApplicationStatuses;
use App\Enums\InterviewStatus;
use App\Enums\InterviewType;
use App\Enums\MediaCollections;
use App\Events\Application\InterviewScheduled;
use App\Mail\Application\External\ApplicantInterviewScheduledEmail;
use App\Mail\Application\Internal\PanelInterviewScheduledEmail;
use App\Models\Application;
use App\Models\Interview;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class InterviewApplicantModal extends Component {

    use WithFileUploads;

    #[Modelable]
    public $open_modal = true;

    #[Reactive]
    public mixed $params = null;

    public Interview|null $interview = null;

    #[Locked]
    public Job $job;

    public array $available_times = [];

    public array $available_days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
    ];

    public array $available_months = [];
    public array $interview_types = [];

    public array $form_fields = [
        'interview_type' => '',
//        'address' => '',
        'link' => '',
        'time' => '9:00',
        'day' => '',
        'month' => '',
        'panel_members' => null
    ];

    public $email_template;

    public $email_subject;

    public $email_body;

    public Collection|null $attachments = null;

    public bool $is_complete = false;

    #[Validate('sometimes|nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048')]
    public $attachment_upload;

    public array $rules = [
        'form_fields.interview_type' => 'required|string',
//        'form_fields.address' => 'required|string',
        'form_fields.link' => 'sometimes|nullable|url',
        'form_fields.time' => 'required|string',
        'form_fields.day' => 'required|string',
        'form_fields.month' => 'required|string',
        'form_fields.panel_members' => 'required|min:1',
//        'email_template' => 'string',
        'email_subject' => 'required|string',
        'email_body' => 'required|string',
        'attachment_upload' => 'sometimes|nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ];

    public function mount( ) {

        //Set attachments to a collection
        $this->attachments = collect();

        //Set the date
        $date = Carbon::now()->setTime(9, 0, 0 );

        //Set the available times
        while( $date <= Carbon::now()->setTime(15, 0, 0 ) ) {
            $this->available_times[] = $date->format('H:i');
            $date->addMinutes(15);
        }

        //Set the default values
        $this->form_fields['time'] = '9:00';
        $this->form_fields['month'] = Carbon::now()->format('F');
        $this->form_fields['day'] = Carbon::now()->format('l');
        $this->available_months = [];

        // Set the available months
        $date = Carbon::now()->startOfMonth();
        while( $date <= Carbon::now()->startOfMonth()->addMonths( 3 ) ) {
            $this->available_months[$date->format('n')] = $date->format('F');
            $date->addMonth();
        }

        // Set the available interview types
        $types = [];
        foreach (InterviewType::cases() as $case) {
            $types[$case->name] = $case->value;
        }
        $this->interview_types = $types;

        // Set the default interview type
        if(sizeof($types) > 0) {
            $this->form_fields['interview_type'] = reset($types);
        }

        // Set the merge tags

    }

    public function updated( $field, $value ) {
        $this->validateOnly( $field );

        if( $field == 'attachment_upload' ){

            $media = null;

            $media = $this->job->addMedia( $this->attachment_upload )->toMediaCollection( MediaCollections::INTERVIEW_DOCUMENTS->value );

//            foreach( $this->params as $application_id ) {
//
//                $application = Application::find( $application_id );
//
//                // $this->authorize('update, add media? ', $application );
//
//                if( $this->attachment_upload instanceof TemporaryUploadedFile ){
//                    $media = $application->addMedia( $this->attachment_upload )->toMediaCollection( MediaCollections::INTERVIEW_DOCUMENTS->value );
//                }
//
//            }

            if( $media ){
                $this->attachments[] = $media;
                $this->attachment_upload = null;
            }

        }

        if( $field == 'email_template' ){
            $this->email_body = Markdown::parse( file_get_contents( resource_path( 'views/email_templates/interviews/template_' . $this->email_template . '.md' ) ) )->toHtml();
        }

        $this->render();

    }

    public function removeAttachment( $attachment_id ){

        if (!auth()->user()->can('school.manage-applications')) {
            session()->flash('error', 'You do not have permission to perform this action.');
            return;
        }

        try {
            $this->job->media()->where( 'id', '=', $attachment_id )->first()->delete();
            session()->flash('message', 'Document deleted successfully.');
        } catch (\Exception $e) {
            dump( $e );
            session()->flash('error', 'Error deleting document.');
        }

    }

    public function submitForm(){

        $this->validate();

        foreach( $this->params as $application_id ) {

            $application = Application::find( $application_id );

            $interview = $application->interview;

            $date = Carbon::createFromTimeString( $this->form_fields['time'] )->setMonth( (int)$this->form_fields['month' ] )->setDay( (int)$this->form_fields['day'] );

//            dd( $date );
            //@TODO Validate the date is in the future and return an error to the user Can this be done in the validation rules?

            if( $interview ) {

                $interview->update( [
                    'status' => InterviewStatus::SCHEDULED->value,
                    'type' => $this->form_fields['interview_type'],
                    'link' => $this->form_fields['link'],
                    'panel_members' => array_keys($this->form_fields['panel_members']),
                    'scheduled_at' => $date,
                ] );

            } else {

                $interview = $application->interview()->create( [
                    'status' => InterviewStatus::SCHEDULED->value,
                    'type'           => $this->form_fields['interview_type'],
                    'link'           => $this->form_fields['link'],
                    'panel_members'  => array_keys($this->form_fields['panel_members']),
                    'scheduled_at'   => $date,
                ] );

            }

            $interview->save();

            // Update the status of the application
            $application->status = ApplicationStatuses::STATUS_PENDING->value;
            $application->save();

            // Send the email to the applicant
            $message = New ApplicantInterviewScheduledEmail( $this->email_subject, $this->email_body );
            foreach( $application->getMedia( MediaCollections::INTERVIEW_DOCUMENTS->value ) as $attachment ){
                $message->attach( $attachment );
            }
            Mail::to( $application->user->email )->send( $message );

            //Email to all panel members.
            $panel_emails = User::query()->whereIn('id', $this->form_fields['panel_members'])->pluck('email')->toArray();
            foreach( $panel_emails as $email ) {
                Mail::to( $email )->send( new PanelInterviewScheduledEmail( 'Interview Scheduled', $this->email_body ) );
            }

            // Dispatch the event
            InterviewScheduled::dispatch( $application );

            $this->is_complete = true;

        }

    }

    public function render() {

        if( $this->open_modal != 'interview-applicant' ) {
            return '<div></div>';
        }

        /**
         * @var Collection $applications
         */
        $applications = Application::whereIn('id', $this->params ?? [] )->get();

        $this->attachments = $this->job->getMedia( MediaCollections::INTERVIEW_DOCUMENTS->value );

        $job = null;
        $panel_members = null;

        if( $applications->isNotEmpty() ){

//            $job = $applications->first()->job;
            $panel_members = $this->job->panel_members;

            if( $panel_members && is_null( $this->form_fields['panel_members' ] ) ){
                $this->form_fields['panel_members'] = $panel_members->pluck( 'email', 'id' )->toArray();
            }

        }

        return view('livewire.application.ats.modals.interview-applicant-modal' )->with( [
            'applications' => $applications,
            'job' => $job,
            'available_members' => $panel_members,
            'interviews' => $this->interview
        ] );

    }

}
