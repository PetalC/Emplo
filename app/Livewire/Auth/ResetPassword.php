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

class ResetPassword extends Component {

    use WireToast;

    #[Url( as: 'token')]
    public string $token = '';

    #[Url( as: 'email')]
    public string $email = '';

    #[Validate('required|min:8|confirmed')]
    public string $password = '';

    #[Validate('required|min:8')]
    public string $password_confirmation = '';

    public function handle_reset() {

        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if( $status === Password::PASSWORD_RESET ){
            toast()
                ->success('Password reset successfully')
                ->pushOnNextPage();
            $this->redirect( route( 'auth' ) );
        } else {
            toast()
                ->warning('An error occurred while trying to reset your password. Please try again.')
                ->push();
        }

//        return $status === Password::PASSWORD_RESET
//            ? redirect()->route('login')->with('status', __($status))
//            : back()->withErrors(['email' => [__($status)]]);

    }

    public function render() {
        return view('livewire.auth.reset_password');
    }


}
