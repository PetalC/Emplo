<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class VerifyEmail extends Component {

    use WireToast;

//    #[Url( as: 'token')]
//    public string $token = '';
//
    public string $email = '';
//
//    #[Validate('required|min:8|confirmed')]
//    public string $password = '';
//
//    #[Validate('required|min:8')]
//    public string $password_confirmation = '';

    public function mount(){

        if( ! Auth::check() ){
            return redirect()->route('auth');
        }

        $this->email = Auth::user()->email;


    }

    public function resend_verification() {

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            toast()->warning('User not found')->push();
            return;
        }

        if ($user->hasVerifiedEmail()) {
            toast()->warning('Your email is already verified.')->pushOnNextPage();
            return redirect()->intended( route('auth') );
        }

        $user->sendEmailVerificationNotification();

        toast()->success('Verification email sent')->pushOnNextPage();

        return redirect()->intended( route('auth') );

    }

    public function render() {
        return view('livewire.auth.verify_email');
    }


}
