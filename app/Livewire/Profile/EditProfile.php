<?php

namespace App\Livewire\Profile;

use App\Enums\LicencingAuthorityTypes;
use App\Enums\MediaCollections;
use App\Models\CitizenshipType;
use App\Models\City;
use App\Models\Country;
use App\Models\Profile;
use App\Models\State;
use App\Models\User;
use App\Services\QCTRegistration;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component {
    use WithFileUploads;

    public User $user;

    #[Validate('image|max:5120')] // 5MB Max
    public $new_avatar;

    public array $fields = [];

    public array $profile_fields = [];

    public array $salary_ranges = [];

    public array $available_countries = [];
    public array $available_states = [];
    public array $available_cities = [];

    public array $citizenship_options = [];

    public function rules() {

        return [
            'fields.first_name'   => 'required|string',
            'fields.last_name'    => 'required|string',
            'fields.email'        => 'required|email',
            'fields.phone_number' => 'required|string',
            'fields.specialities' => 'required|array:min:1',
            'fields.right_to_work' => 'required|string|in:Yes,No',
            'fields.citizenship' => 'required|exists:citizenship_types,id',
            'profile_fields.suitable_for_work' => 'accepted|bool',
            'profile_fields.minimum_salary' => 'required|int',
            'profile_fields.maximum_salary' => 'required|int',
            'profile_fields.faith_reference' => 'required|string|in:Yes,No',
            'profile_fields.brief' => 'required|string|max:200',
            'fields.registration_type' => [ 'required', ( new Enum( LicencingAuthorityTypes::class ) ) ],
            'fields.registration_number' => 'required|numeric',
            'fields.registration_expiry' => 'required|string',
            'new_avatar' => 'nullable|image|max:2048',
            'profile_fields.city' => 'required|string',
            'profile_fields.state' => 'required|int',
            'profile_fields.country' => 'required|int',
        ];
    }

    public function mount(){

        $certification = $this->user->certifications()->first();

        $this->fields = [
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'phone_number' => $this->user->phone_number,
            'citizenship' => $this->user->profile->citizenship_id ?? CitizenshipType::query()->first()->id,
            'current_position_types' => $this->user->current_position_types->pluck('name', 'id')->toArray(),
            'preferred_position_types' => $this->user->preferred_position_types->pluck('name', 'id')->toArray(),
            'specialities' => $this->user->subjects->pluck('name', 'id')->toArray(),
            'preferred_job_lengths' => $this->user->preferred_job_lengths->pluck('name', 'id')->toArray(),
            'preferred_school_types' => $this->user->preferred_school_types->pluck('name', 'id')->toArray(),
            'registration_type' => $certification->certification ?? LicencingAuthorityTypes::OTHER->value,
            'registration_number' => $certification->certification_id ?? 0,
            'registration_expiry' => $certification->expires_at ?? '',
        ];

        if( $this->fields['registration_type'] === '' ){
            $this->fields['registration_type'] = LicencingAuthorityTypes::OTHER->value;
        }

        $this->profile_fields = [
            'brief' => $this->user->profile->brief,
            'right_to_work' => $this->user->profile->right_to_work ? 'Yes' : 'No',
            'faith_reference' => $this->user->profile->faith_reference ? 'Yes' : 'No',
            'suitable_for_work' => $this->user->profile->suitable_for_work,
            'minimum_salary' => (int)$this->user->profile->minimum_salary,
            'maximum_salary' => (int)$this->user->profile->maximum_salary,
            'country' => $this->user->profile->country,
            'state' => $this->user->profile->state,
            'city' => $this->user->profile->city
        ];

        /**
         * Handle the loading of relevant states / cities.
         */
        $country = false;
        $state = false;

        if( $this->user->profile->country ){
            $country = Country::where( 'name', $this->user->profile->country )->first();
            if( $country ){
                $this->available_states = State::where( 'country_id', $country->id )->pluck( 'name', 'id' )->toArray();
                $this->profile_fields['country'] = $country->id;
            }
        }

        if( $this->user->profile->state && $country ){
            $state = State::where( 'name', $this->user->profile->state )->where( 'country_id', $country->id )->first();
            if( $state ){
                $this->available_cities = City::where( 'state_id', $state->id )->pluck( 'name', 'id' )->toArray();
                $this->profile_fields['state'] = $state->id;
            }
        }

        if( $this->user->profile->city && $state ){
            $city = City::where( 'name', $this->user->profile->city )->where( 'state_id', $state->id )->first();
            if( $city ){
                $this->profile_fields['city'] = $city->id;
            }
        }

        /**
         * Other variables for the template.
         */
        $this->salary_ranges = range( 50000, 200000, 5000 );
        $this->available_countries = Country::all()->pluck('name', 'id' )->toArray();
        $this->citizenship_options = CitizenshipType::all()->pluck('name', 'id')->toArray();

    }

    public function updated( $field, $value ){

        $this->validateOnly( $field );

        $field_name = $field;

        if( Str::startsWith( $field, 'fields.' ) ){
            $field_name = Str::after( $field, 'fields.' );
        }

        if( Str::startsWith( $field, 'profile_fields.' ) ){
            $field_name = Str::after( $field, 'profile_fields.' );
        }

        switch( $field ){

            case 'fields.first_name':
            case 'fields.last_name':
            case 'fields.email':
            case 'fields.phone_number':
                $this->user->{$field_name} = $value;
                $this->user->save();
                break;

            case 'fields.citizenship':
                $this->user->profile->citizenship()->associate( $value );
                $this->user->profile->save();
                break;

            case 'profile_fields.suitable_for_work':
            case 'profile_fields.minimum_salary':
            case 'profile_fields.maximum_salary':
            case 'profile_fields.brief':
                $this->user->profile->{$field_name} = $value;
                $this->user->profile->save();
                break;

            case 'profile_fields.right_to_work':
            case 'profile_fields.faith_reference':
                $this->user->profile->{$field_name} = ( $value === 'Yes' );
                $this->user->profile->save();
                break;

            case 'profile_fields.country':
                $this->user->profile->country = Country::where( 'id' , $value )->first()->name;
                $this->user->profile->save();

                $this->available_states = State::where( 'id', $value )->pluck( 'name', 'id' )->toArray();

                break;

            case 'profile_fields.state':
                $this->user->profile->state = State::where( 'id' , $value )->first()->name;
                $this->user->profile->save();

                $this->available_cities = City::where( 'state_id', $value )->pluck( 'name', 'id' )->toArray();

                break;

            case 'profile_fields.city':
                $this->user->profile->city = $value;
                $this->user->profile->save();
                break;

        }

        /**
         * Spacility Areas
         */
        if( Str::startsWith( $field, 'fields.specialities' ) ){
            $this->user->subjects()->sync( array_keys( $this->fields['specialities'] ) );
        }

        /**
         * Preferred Job Lengths
         */
        if( Str::startsWith( $field, 'fields.preferred_job_lengths' ) ){
            $this->user->preferred_job_lengths()->sync( array_keys( $this->fields['preferred_job_lengths'] ) );
        }

        /**
         * Preferred School Types
         */
        if( Str::startsWith( $field, 'fields.preferred_school_types' ) ){
            $this->user->preferred_school_types()->sync( array_keys( $this->fields['preferred_school_types'] ) );
        }

        /**
         * Current Position Types
         */
        if( Str::startsWith( $field, 'fields.current_position_types' ) ){

            $this->user->current_position_types()->sync( [] );

            foreach( $this->fields['current_position_types'] as $position_type_id => $position_type_name ){
                $this->user->current_position_types()->attach( $position_type_id, [
                    'category' => 'current'
                ] );
            }

        }

        /**
         * Preferred Position Types
         */
        if( Str::startsWith( $field, 'fields.preferred_position_types' ) ){

            $this->user->preferred_position_types()->sync( [] );

            foreach( $this->fields['preferred_position_types'] as $position_type_id => $position_type_name ){
                $this->user->preferred_position_types()->attach( $position_type_id, [
                    'category' => 'preferred'
                ] );
            }

        }

        /**
         * Certification Registration
         */
        if( in_array( $field, ['fields.registration_type', 'fields.registration_number', 'fields.registration_expiry'] ) ){
            /**
             * Bit of a hack, but we're only allowing one certification per user
             * Also need to have the QCT registration number validated.
             * Having that inline here means we are able to quickly demo the functionality
             */
            $certification = $this->user->certifications()->first();

            if( ! $certification ){

                /**
                 * If there is no certification and we have enough info to create one then do so.
                 */
                $certification = $this->user->certifications()->create([
                    'certification' => '',
                    'certification_id' => '',
                    'expires_at' => '',
                ]);

            }

            /**
             * Validation is run on an observer to update.
             */
            $certification->update([
                'certification' => $this->fields['registration_type'],
                'certification_id' => $this->fields['registration_number'],
                'expires_at' => $this->fields['registration_expiry'],
            ] );

        }

        /**
         * Avatar
         */
        if( $field == 'new_avatar' ){
            $this->user->profile->clearMediaCollection( MediaCollections::USER_PROFILE->value);
            $this->user->profile->addMedia( $value )->toMediaCollection( MediaCollections::USER_PROFILE->value );
            $this->new_avatar = null;
        }

    }

    public function addNewExperience(){
        $this->user->experiences()->create([
            'company' => '',
            'story' => '',
            'role' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->render();
    }

    public function addNewEducation(){
        $this->user->educations()->create([
            'school' => '',
            'degree' => '',
            'story' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->render();
    }

    public function addNewCertification(){
        $this->user->profile_certifications()->create();

        $this->render();
    }

    public function validateAll(){
        $this->validate();
    }

    #[On('experience_updated')]
    #[On('education_updated')]
    #[On('profile_certification_updated')]
    public function refreshProfile(){
        $this->user->refresh();
    }


    public function render() {
        return view('livewire.profile.edit-profile');
    }

}
