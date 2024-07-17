<?php

namespace App\Livewire\Auth;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Login extends Component {

    use WireToast;

    #[Validate('required')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public $forgotten_password = false;

    public function render() {
        return view('livewire.auth.login');
    }

    public function login() {
        $credentials = $this->validate();

        try {
            if (Auth::attempt($credentials)) {

                /**
                 * If a user is associated with more than 1 school, they need a page to select the school they are currently managing.
                 *
                 * If the user is associated with only 1 school, set the session and redirect to the school dashboard.
                 *
                 * @var \App\Models\User $user
                 */
                $user = Auth::user();
                $user->load('schools');

                /**
                 * @TODO Handle login better when we get the permissions mapped out to a workable plan.
                 */
                if( $user->can( 'school.view-dashboard' ) ) {

                    if ( $user->schools->count() < 1 ) {
                        throw new \Exception( 'User has no schools attached' );
                    } else {
                        return redirect()->route( 'school.dashboard' );
                    }

                } elseif( $user->can( 'nova.view' ) ){
                    return redirect()->route( 'nova.pages.home' );
                } else {
                    return redirect()->route( 'profile' );
                }

            } else {
                throw new Exception('Invalid email or password');
            }
        } catch (Exception $e) {
            toast()
                ->warning($e->getMessage())
                ->push();
        }
    }

    public function reset_password(){

        $this->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if( $status === Password::RESET_LINK_SENT ){
            toast()
                ->success('Password reset link sent to your email')
                ->push();
        } else {
            toast()
                ->error('An error occurred while trying to send the password reset link')
                ->push();
        }


    }

}
