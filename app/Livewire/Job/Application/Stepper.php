<?php

namespace App\Livewire\Job\Application;

use App\Enums\ApplicationStatuses;
use App\Enums\LicencingAuthorityTypes;
use App\Enums\MediaCollections;
use App\Enums\VacancyReasons;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\Uid\Ulid;

/**
 * Render the job application stepper
 */
class Stepper extends Component {

    use WithFileUploads;

    public $active_component;



//    #[Locked]
//    public int $total_steps = 0;



    #[Locked]
    public $job;

    #[Locked]
    public $steps;

    #[Locked]
    public $user;

    public $previousTitle = '';
    public $nextTitle = '';
    public $showingBothNavButtons = false;
    public $showSaveDetails = true;

    public bool $save_details = false;
    public bool $declared_suitable = false;

    public array $user_details = [];

    public array $application_details = [];

    public array $references = [];
//        [
//            'full_name' => '',
//            'email' => '',
//            'phone_number' => '',
//            'position' => '',
//        ]
//    ];

    public array $documents;
    public array $school_documents = [];

    public $document_upload;

    public $school_document_upload;

    public $min_references = 2;

    public bool $application_complete = false;

    public $captcha = null;

    public array $selected_subjects = [];

    //'fields.vacancy_reason' => [ 'required', ( new Enum( VacancyReasons::class ) ) ],
    protected $user_rules = [
        'user_details.first_name' => 'required|string',
        'user_details.last_name' => 'required|string',
        'user_details.phone' => 'required|string',
        'user_details.email' => 'required|email',
        'user_details.suburb' => 'required|string',
        'user_details.state' => 'required|string',
        'user_details.country' => 'required|string',
        'user_details.registration' => 'required|array',
        'user_details.registration.licence' => 'required|string',//@TODO BEN Update this to ENUM
        'user_details.registration.licence_number' => 'required|string',
        'user_details.registration.licence_expiry' => 'required|string',
    ];

    /**
     *
     * @var string[]
     */
    protected $application_rules = [
        'application_details.specialities' => 'required|array',
        'application_details.right_to_work' => 'required|string',
        'application_details.current_location' => 'required|string',
        'application_details.job_type' => 'required|string',
        'application_details.referred_method' => 'required|string',
    ];

    protected $reference_rules = [
        'references' => 'sometimes|nullable|array',
        'references.*.full_name' => 'required|string',
        'references.*.email' => 'required|email',
        'references.*.phone_number' => 'required|string',
        'references.*.position' => 'required|string',
    ];

    protected $documents_rules = [
        'documents' => 'required|array',
        'documents.*' => 'required|file',
    ];

    /**
     * @var string[] @TODO Finish These Messages
     */
    protected $messages = [
        'user_details.first_name.required' => 'First name is required',
        'user_details.last_name.required' => 'Last name is required',
        'user_details.phone.required' => 'Phone number is required',
        'user_details.email.required' => 'Email is required',
        'user_details.email.email' => 'Please enter a valid email address',
    ];

    public function mount( Job $job = null ) {
        $this->job = $job;
        $this->steps = $this->steps();
        $this->total_steps = count($this->steps) - 1;
        $this->active_component = $this->steps()[0];
        $this->loadComponent();

        if( Auth::check() ){
            $this->user = Auth::user();
        }

        $this->user_rules['user_details.registration.licence'] = [ 'required', ( new Enum( LicencingAuthorityTypes::class ) ) ];
        //user_details.registration.licence

        // Pre Fill
        if( $this->application_id ){
            $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

            if( ! $application ){
                return false;
            }

            if( $application->status !== ApplicationStatuses::STATUS_DRAFT ){
                $this->application_complete = true;
            }

            $this->user_details = [
                'first_name' => $application->user->first_name,
                'last_name' => $application->user->last_name,
                'phone' => $application->user->phone_number,
                'email' => $application->user->email,
                'suburb' => $application->user->profile?->city,
                'state' => $application->user->profile?->state,
                'country' => $application->user->profile?->country,
                'registration' => $application->registration ?? [
                    'licence' => '',
                    'licence_number' => '',
                    'licence_expiry' => '',
                ],
            ];

            $this->application_details = [
                'specialities' => $application->specialities,
                'right_to_work' => $application->right_to_work ? 'Yes' : 'No',
                'current_location' => $application->current_location,
                'job_type' => $application->job_type,
                'referred_method' => $application->referred_method,
            ];

            $this->save_details = $application->save_details;
            $this->declared_suitable = $application->suitable_declared;

            $this->documents = $application->getMedia( MediaCollections::APPLICATION_DOCUMENTS->value )->all();
            $this->school_documents = $application->getMedia( MediaCollections::APPLICATION_SCHOOL_DOCUMENTS->value )->all();

            $this->references = $application->reference_checks->map( function( $reference ){
                return [
                    'full_name' => $reference->referee->name,
                    'email' => $reference->referee->email,
                    'phone_number' => $reference->referee->phone,
                    'position' => $reference->referee->position,
                ];
            } )->all();

        } else {

            $this->application_details = [
                'right_to_work' => 'No',
            ];

            // If the user is logged in, Prefill the basic details.
            if( Auth::check() ){
                $user = Auth::user();
                $this->user_details = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'phone' => $user->phone_number,
                    'email' => $user->email,
                ];
            }

//            $this->right

        }
    }

    public function rules(){
        return array_merge( [
            'save_details' => 'sometimes|nullable|boolean',
            'declared_suitable' => 'boolean|required',
//            'captcha' => 'required',
        ], $this->user_rules, $this->application_rules );
    }

    public function criteriaStepRules(){
        return array_merge( [
            'save_details' => 'sometimes|nullable|boolean',
            'declared_suitable' => 'accepted',
        ], $this->application_rules, $this->user_rules );
    }

    /**
     * Enable live validation of individual fields.
     */
    public function updated($propertyName, $value) {
        $this->validateOnly($propertyName);

        if( $propertyName == 'document_upload' ){

            $this->validate( [
                'document_upload' => 'required|file'
            ] );

            if( $this->application_id ){

                /**
                 * @var \App\Models\Application $application
                 */
                $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

                if( $application ){

                    $application->addMedia( $this->document_upload )
                        ->usingFileName( $this->document_upload->getClientOriginalName() )
                        ->toMediaCollection( MediaCollections::APPLICATION_DOCUMENTS->value );

                }

            }

            $this->documents = $application->getMedia( MediaCollections::APPLICATION_DOCUMENTS->value )->all();

            $this->document_upload = null;

        }

        if( $propertyName == 'school_document_upload' ){

            $this->validate( [
                'school_document_upload' => 'required|file'
            ] );

            if( $this->application_id ){

                /**
                 * @var \App\Models\Application $application
                 */
                $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

                if( $application ){

                    $application->addMedia( $this->document_upload )
                        ->usingFileName( $this->document_upload->getClientOriginalName() )
                        ->toMediaCollection( MediaCollections::APPLICATION_SCHOOL_DOCUMENTS->value );

                }

            }

            $this->school_documents = $application->getMedia( MediaCollections::APPLICATION_SCHOOL_DOCUMENTS->value )->all();

            $this->school_document_upload = null;

        }

        if( $propertyName == 'captcha' ){

            $response = Http::post(
                'https://www.google.com/recaptcha/api/siteverify?secret='.
                env('RECAPTCHA_SECRET_KEY').
                '&response='.$value
            );

            $success = $response->json()['success'];

            if ( ! $success ) {
                $this->captcha = null;
                $this->addError('captcha', 'Google thinks, you are a bot, please refresh and try again!' );
            } else {
                $this->captcha = true;
            }

        }


    }

    public function saveUserDetails(){

        $this->validate( $this->user_rules );

        $user = $this->user;

//        if( $user && isset( $this->user_details['email'] ) && $this->user_details['email'] !== $user->email ){
//            $this->addError('user_details.email', 'You are already logged in with a different email address' );
//        }

        if( ! $user && isset( $this->user_details['email'] ) ){

            // Guest Application.
            $user = User::where('email', $this->user_details['email'] )->first();

            if( ! $user ){

                try{
                    $user = new User( [
                        'disabled' => $this->save_details ? 0 : 1,
                        'password' => Hash::make( Str::random( 8 ) ),
                    ] );
                } catch (\Exception $e){
//                    return false;
                }

            }

            if( $user ){

//                dump( $this->user_details );

                $user->fill( [
                    'first_name' => $this->user_details['first_name'],
                    'last_name' => $this->user_details['last_name'],
                    'phone_number' => $this->user_details['phone'],
                    'email' => $this->user_details['email'],
                ] );

                $user->save();

                $user->profile()->updateOrCreate( [
                    'user_id' => $user->id
                ], [
                    'mobile_number' => $this->user_details['phone'],
                    'state' => $this->user_details['state'],
                    'city' => $this->user_details['suburb'],
                    'country' => $this->user_details['country'],
                    'right_to_work' => ( $this->application_details['right_to_work'] === 'Yes' ) ? true : false,
                ] );

                $user->certifications()->updateOrCreate( [
                    'certification' => $this->user_details['registration']['licence']
                ], [
                    'certification_id' => $this->user_details['registration']['licence_number'],
                    'expires_at' => Carbon::createFromFormat( 'm/y', $this->user_details['registration']['licence_expiry'] ),
                ] );

                $this->user = $user;

            }

        }

        if( $this->user ){

            if( $this->save_details ){

                $this->user->fill( [
                    'first_name' => $this->user_details['first_name'],
                    'last_name' => $this->user_details['last_name'],
                    'phone_number' => $this->user_details['phone'],
                    'email' => $this->user_details['email'],
                ] );
                $this->user->save();

                $this->user->profile()->updateOrCreate( [
                    'user_id' => $this->user->id
                ], [
                    'mobile_number' => $this->user_details['phone'],
                    'state' => $this->user_details['state'],
                    'city' => $this->user_details['suburb'],
                    'country' => $this->user_details['country'],
                ] );
            }

        }

    }

    public function saveApplicationDetails(){

//        $this->validate();

        if( ! $this->user ){
            // Not enough information to store yet.
            return;
        }

        if( ! $this->application_id ){
            $application = $this->job->applications()->create([
                'ulid' => Ulid::generate( now() ),
                'user_id' => $this->user->id,
                'job_id' => $this->job->id,
                'campus_id' => $this->job->campus_id,
            ] );
            $this->application_id = $application->ulid;
        }

        $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

        if( ! $application ){
            return false;
        }

        $application->fill( [
            'specialities' => $this->application_details['specialities'] ?? [],
//            'registration' => $this->application_details['registration'] ?? [], Moving to the Certifications model.
            'right_to_work' => ( isset( $this->application_details['right_to_work'] ) && $this->application_details['right_to_work'] === 'Yes'  ) ? 1 : 0,
            'current_location' => $this->application_details['current_location'] ?? '',
            'job_type' => $this->application_details['job_type'] ?? '',
            'referred_method' => $this->application_details['referred_method'] ?? '',
            'save_details' => $this->save_details ? 1 : 0,
            'suitable_declared' => $this->declared_suitable ? 1 : 0,
        ] );

        $application->save();

    }

    public function addReference(){
        $this->references[] = [
            'full_name' => '',
            'email' => '',
            'phone_number' => '',
            'position' => '',
        ];
    }

    public function removeReference( $index ){
        unset( $this->references[$index] );
    }

    public function saveReferences(){

        $this->validate( $this->reference_rules );

        if( $this->application_id ){

            $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

            if( $application ){

                $application->reference_checks()->delete();

                foreach( $this->references as $reference ){

                    $referee = $application->user->referees()->where( 'email', $reference['email'] )->first();

                    if( ! $referee ){
                        $referee = $application->user->referees()->create( [
                            'name' => $reference['full_name'],
                            'email' => $reference['email'],
                            'phone' => $reference['phone_number'],
                            'position' => $reference['position'],
                        ] );
                    }

                    $reference_check = $application->reference_checks()->create( [
                        'ulid' => Ulid::generate( now() ),
                        'referee_id' => $referee->id,
                        'candidate_id' => $application->user->id,
                        'status' => 'draft',
                        'comment' => '',
                    ] );

                }

            }

        }

    }

//    public function removeDocument( $document_id ){
//
//        if( $this->application_id ) {
//
//            /**
//             * @var \App\Models\Application $application
//             */
//            $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();
//
//            $application->deleteMedia( $document_id );
//
////            sleep( 2 );
//
////            $this->documents = $application->getMedia( MediaCollections::APPLICATION_DOCUMENTS->value )->all();
//
//            $this->mount( $this->job );
//            $this->render();
//
//        }
//
//    }

    public function submitApplication(){

        $this->validate();



        if( $this->application_id ){

            $application = $this->job->applications()->where( 'ulid', $this->application_id )->first();

            if( $application ){

                $application->fill( [
                    'status' => ApplicationStatuses::STATUS_SUBMITTED
                ] );

                $application->save();

                $this->application_complete = true;

                // @TODO Trigger Emails, Notifications and Checks.

            }

        }

    }

    public function nextComponent() {

        if( $this->active_component === 'criteria' ){
            $this->validate( $this->criteriaStepRules() );
            $this->saveUserDetails();
            $this->saveApplicationDetails();
        } elseif( $this->active_component === 'documents' ) {
            $this->validate( $this->reference_rules );
            $this->saveReferences();
        }

        if ($this->current_component == $this->total_steps) {
            // fire completed stepper event
            $this->dispatch('job.'.$this->job->id.'-application-stepper-complete', $this->job);
            $this->submitApplication();
            return;
        }
        $this->current_component++;
        $this->loadComponent();

        $this->dispatch('refresh-captcha');
    }

    public function previousComponent() {
        $this->current_component--;
        $this->loadComponent();
    }

    public function jumpToComponent(int $index) {
        $this->current_component = $index;
        $this->loadComponent();
    }
    public function loadComponent() {
        $new_step = $this->steps[$this->current_component];
        if ($new_step) {
            $this->active_component = $new_step;
        } else {
            $this->active_component = 'invalid';
        }
        $this->previousTitle = $this->getPreviousTitle();
        $this->nextTitle = $this->getNextTitle();
        $this->showingBothNavButtons = $this->current_component > 1 && $this->current_component;
        $this->showSaveDetails = $this->active_component !== 'submit';
    }

    public function steps(): array {
        return [
            'criteria',
            'documents',
            'submit'
        ];
    }

    public function getPreviousTitle(): string {
        switch ($this->active_component) {
            case 'test':
                return 'N/A';
            case 'criteria':
                return 'Test';
            case 'documents':
                return 'Previous Step';
            case 'submit':
                return 'Previous Step';
            default:
                return '';
        }
    }


    public function getNextTitle(): string {
        switch ($this->active_component) {
            case 'test':
                return 'Apply';
            case 'criteria':
                return 'Upload Documents';
            case 'documents':
                return 'Review application';
            case 'submit':
                return 'Confirm & Submit';
            default:
                return '';
        }
    }

    public function render() {
        return view( 'livewire.job.application.stepper' );
    }
}
