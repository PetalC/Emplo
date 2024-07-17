<?php

namespace App\Livewire\Job\Application;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Render the job application complete screen
 */
class Complete extends Component {

    public Job $job;

    #[Modelable]
    public Application $application;

    public string $password = '';

    public string $password_confirmation = '';

    public bool $save_application_complete = false;

    public function rules(){

        $password_rule = ( new Password( 8 ) );

        if( env( 'APP_ENV' ) == 'production' ){
            $password_rule->uncompromised();
        }

        return [
            'password' => ['required', 'confirmed', $password_rule ],
            'password_confirmation' => 'required'
        ];
    }

    public function messages(){
        return [
            'password.required' => 'Please enter a password',
            'password.confirmed' => 'Passwords do not match',
            'password.min' => 'Password must be at least 8 characters long',
            'password.letters' => 'Password must contain at least one letter',
            'password.mixedCase' => 'Password must contain at least one uppercase and one lowercase letter',
            'password.numbers' => 'Password must contain at least one number',
            'password.symbols' => 'Password must contain at least one symbol',
            'password.uncompromised' => 'This password appears to have been compromised. Please choose a different password',
            'password_confirmation.required' => 'Please confirm your password'
        ];
    }

    public function updated( $property, $value ){
        $this->validate();
    }

    /**
     * Convert temporary user into a saved user
     *
     * @return void
     */
    public function saveApplication() {

        $this->validate();

        //Mark the save_details flag as true
        $this->application->save_details = true;
        $this->application->save();

        /**
         * Update the users details.
         *
         * @var User $user
         */
        $user = $this->application->user;
        //@NATE should we add a "hidden" field to the user model to indicate that the user is not yet saved? We may want to use disabled later for other purposes?.
        $user->disabled = false;

        //Ensure all speciality fields come back to the user
        $user->subjects()->sync( array_keys( $this->application->specialities ) );

        if( $this->password != '' ){
            $user->password = Hash::make( $this->password );
        }

        $user->save();

        /**
         * Send the email verification notification
         */
        $this->application->user->sendEmailVerificationNotification();

        /**
         * Email verification requires the user to be logged in.
         *
         * We will log the user in and redirect them to /auth, where they will be redirected to the dashboard, then to the verify email page.
         */
        auth()->login( $this->application->user );

        $this->redirect( route( 'auth' ) );

    }

    public function render() {
        return view( 'livewire.job.application.complete' );
    }
}
