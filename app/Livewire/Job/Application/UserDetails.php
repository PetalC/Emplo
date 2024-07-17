<?php

namespace App\Livewire\Job\Application;

use App\Enums\JobType;
use App\Enums\LicencingAuthorityTypes;
use App\Livewire\Job\Apply;
use App\Models\Application;
use App\Models\Country;
use App\Models\Job;
use App\Models\State;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Symfony\Component\Uid\Ulid;

class UserDetails extends Component {

    public Job $job;

    public User|null $user = null;

    #[Modelable]
    public Application|null $application = null;

    public array $authority_types = [];
    public array $application_source_options = [
        'Employo',
        'SEEK',
        'Teachers on Net',
        'Indeed',
        'Education HQ',
        'LinkedIn',
        'Facebook',
        'Instagram',
        'Sportpeople',
        'Christian Jobs',
        'Ethical Jobboard',
        'CareerOne',
        'University Dashboard',
        'Educationpost.ie',
        'Adzuna',
        'School Website',
        'Referred',
        'Previous/Current Employee',
        'Jora',
        'Other'
    ];

    public array $country_options = [];

    public array $state_options = [];
    public array $specialities_preselect = [];

    public array $current_occupation_options = [
        'Teaching',
        'Studying',
        'Non-Teaching role (school based)',
        'Middle Management (school based)',
        'Senior Leadership (school based)',
        'Principal (school based)',
        'I am not working in a School',
    ];


    public array $fields = [
        'first_name' => '',
        'last_name' => '',
        'mobile_number' => '',
        'email' => '',
        'country' => '',
        'state' => '',
        'city' => '',
        'right_to_work' => false,
        'current_occupation' => '',
        'job_type' => JobType::FULLTIME,
        'referred_method' => '',
        'registration_licence' => LicencingAuthorityTypes::OTHER,
        'registration_licence_number' => '',
        'registration_licence_expiry' => '',
        'suitable_declared' => false,
//        'save_details' => false,
        'specialities' => [],
    ];

    public function rules() {
        return [
            'fields.first_name' => 'required|string',
            'fields.last_name' => 'required|string',
            'fields.mobile_number' => 'required|string',
            'fields.email' => 'required|email',
            'fields.city' => 'required|string',
            'fields.state' => 'required|string',
            'fields.country' => 'required|string',
//            'registration' => 'required|array',
            'fields.registration_licence' => [ ( new Enum( LicencingAuthorityTypes::class ) ) ],
            'fields.registration_licence_expiry' => 'string',
            'fields.registration_licence_number' => 'string',
            'fields.specialities' => 'required|array|min:1',
            'fields.right_to_work' => 'required|boolean',
            'fields.current_occupation' => 'required|string',
            'fields.suitable_declared' => 'accepted',
            'fields.job_type' => [ 'required', ( new Enum( JobType::class ) ) ],
        ];
    }

    public function messages(){
        return [
            'fields.first_name.required' => 'Please enter your first name',
            'fields.last_name.required' => 'Please enter your last name',
            'fields.phone.required' => 'Please enter your phone number',
            'fields.email.required' => 'Please enter your email address',
            'fields.email.email' => 'Please enter a valid email address',
            'fields.suburb.required' => 'Please enter your suburb',
            'fields.state.required' => 'Please enter your state',
            'fields.country.required' => 'Please enter your country',
            'fields.registration_licence_expiry.required' => 'Please enter your registration licence expiry date',
            'fields.right_to_work.required' => 'Please select your right to work status',
            'fields.current_occupation.required' => 'Please select your current occupation',
            'fields.suitable_declared.accepted' => 'Please confirm that you have declared your suitability',
            'fields.job_type.required' => 'Please select the job type you are applying for',
        ];
    }

    public function potentiallyCreateUser( $email = '' ){

        /**
         * Check if the email address is already in use. If it is we can attach the user to the application.
         */
        $user = User::where( 'email', $email )->first();

        /**
         * If we don't have a user, and we have enough information to create one, we can create one.
         */
        $minimum_user_rules = [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ];

        $test_data = [
            'email' => $this->fields['email'],
            'first_name' => $this->fields['first_name'],
            'last_name' => $this->fields['last_name'],
        ];

        if( $user ){

            $this->user = $user;

        } elseif( Validator::make( $test_data, $minimum_user_rules )->passes() ){

            $user = new User( [
                'first_name' => $this->fields['first_name'],
                'last_name' => $this->fields['last_name'],
                'email' => $this->fields['email'],
                'disabled' => true,
                'password' => Hash::make( Str::random( 16 ) ),
            ] );

            $user->save();

            $user->profile()->create( [
                'mobile_number' => $this->fields['mobile_number'],
                'right_to_work' => $this->fields['right_to_work'],
                'state' => $this->fields['state'],
                'country' => $this->fields['country'],
                'city' => $this->fields['city'],
            ] );

            $user->assignRole( 'Job Seeker' );

            $this->user = $user;

            $this->dispatch( 'user_created', $user )->to( Apply::class );

        }

    }

    public function mount(){

        $this->authority_types = LicencingAuthorityTypes::cases();

        foreach( $this->authority_types as $key => $enum ){
            if( $enum->name === 'NONE' ){
                unset( $this->authority_types[$key] );
            }
        }

        $this->country_options = Country::all()->pluck('name', 'name')->toArray();

        $this->specialities_preselect = Subject::all()->random( 20 )->pluck( 'name', 'id' )->toArray();

        // If we are not logged in and have an application, we can set the user to the application user.
        //@TODO Security Analysis. How do we let users who are not logged in edit their applications?
        //@TODO We need to make sure that the user is the owner of the application. Perhaps something in the session?
        //@TODO The application_id is a ULID, so fairly secure, but something in the session to validate the other way as well ?
        if( ! auth()->check() ){
            if( $this->application && $this->application->user ){
                $this->user = $this->application->user;
            }
        }

        if( $this->user ){
            $this->fields['first_name'] = $this->user->first_name;
            $this->fields['last_name'] = $this->user->last_name;
            $this->fields['mobile_number'] = $this->user->profile?->mobile_number;
            $this->fields['email'] = $this->user->email;
            $this->fields['right_to_work'] = (int)$this->user->profile?->right_to_work;
            $this->fields['state'] = $this->user->profile?->state;
            $this->fields['country'] = $this->user->profile?->country;
            $this->fields['city'] = $this->user->profile?->city;

            $licence = $this->user->certifications()->first();

            if( $licence ){
                $this->fields['registration_licence'] = $licence?->certification;
                $this->fields['registration_licence_number'] = $licence?->certification_id;
                $this->fields['registration_licence_expiry'] = $licence?->expires_at;
            }

            if( $this->fields['country'] ){
                $this->state_options = State::query()
                    ->whereHas( 'country', fn( $query ) => $query->where( 'name', $this->fields['country'] ) )
                    ->pluck('name', 'name')
                    ->toArray();
            }

        }

        if( $this->application ){
            $this->fields['current_occupation'] = $this->application->current_occupation;
            $this->fields['job_type'] = $this->application->job_type;
            $this->fields['referred_method'] = $this->application->referred_method;
//            $this->fields['save_details'] = $this->application->save_details;
            $this->fields['suitable_declared'] = $this->application->suitable_declared;
            $this->fields['specialities'] = $this->application->specialities;
        }

    }

    public function updated( $property, $value ) {
        $this->validateOnly( $property );

        /**
         * Business logic about when to create a user and an application. Currently this is all triggered by the email address.
         * If the email address is entered, and we don't have a user or an application, we can create them, and if we validate that and don't have an application, we can create here one as well..
         */
        if( $property === 'fields.email' && ! $this->application ){

            if( ! $this->user ){
                $this->potentiallyCreateUser( $value );
            }

            if( $this->user ){

                /**
                 * If the user is valid, but we don't have an application, we can create one.
                 */
                $application = $this->job->applications()->create([
                    'ulid' => Ulid::generate( now() ),
                    'user_id' => $this->user->id,
                    'job_id' => $this->job->id,
                    'campus_id' => $this->job->campus_id,
                ] );

                $this->application = $application;

                $this->dispatch( 'application_created', $application )->to( Apply::class );

                return;

            }

        }

        $field_name = Str::after( $property, 'fields.' );

        if( $this->user ){

            switch ( $property ){

                case 'fields.registration_licence':
                case 'fields.registration_licence_number':
                case 'fields.registration_licence_expiry':
                    if( $this->fields['registration_licence'] && $this->fields['registration_licence_number'] && $this->fields['registration_licence_expiry'] ){

                        $certification = $this->user->certifications()->first();

                        $data = [
                            'certification' => $this->fields['registration_licence'],
                            'certification_id' => $this->fields['registration_licence_number'],
                            'expires_at' => $this->fields['registration_licence_expiry'],
                        ];

                        if( ! $certification ){
                            $this->user->certifications()->create( $data );
                        } else {
                            $certification->update( $data );
                        }
                    }
                    break;

                case 'fields.email':
                case 'fields.first_name':
                case 'fields.last_name':
                    $this->user->{$field_name} = $value;
                    $this->user->save();
                    break;

                case 'fields.mobile_number':
                case 'fields.state':
                case 'fields.city':
                case 'fields.right_to_work':
                    $this->user->profile->{$field_name} = $value;
                    $this->user->profile->save();
                    break;

                case 'fields.country':
                    $this->user->profile->{$field_name} = $value;

                    $this->state_options = State::query()
                        ->whereHas( 'country', fn( $query ) => $query->where( 'name', $this->fields['country'] ) )
                        ->pluck('name', 'name')
                        ->toArray();
                    break;

            }

            $this->user->save();
            $this->user->profile->save();

        }

        if( $this->application ){

            switch( $property ){
                case 'fields.current_occupation':
                case 'fields.job_type':
                case 'fields.referred_method':
//                case 'fields.save_details':
                    $this->application->{$field_name} = $value;
                    break;

                case 'fields.suitable_declared':
                    $this->validate();// This will validate all the fields.
                    $this->application->{$field_name} = $value;
                    break;

            }

            if( Validator::make( [ 'fields' => $this->fields ], $this->rules() )->passes() ){
                $this->application->validated_step = 'criteria';
            }

            if( Str::startsWith( $property, 'fields.specialities' ) ){
                $this->application->specialities = $this->fields['specialities'];
            }

            $this->application->save();

        }

        $this->render();

    }

    public function render() {
        return view('livewire.job.application.user-details');
    }
}
