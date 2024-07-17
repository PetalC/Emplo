<?php

namespace App\Livewire\Auth\School;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Register extends Component
{
    use WireToast;

    #[Validate('required')]
    public string $firstName = '';

    #[Validate('required')]
    public string $lastName = '';

    #[Validate('required')]
    public string $phoneNumber = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    #[Validate('required|same:password')]
    public string $password2 = '';

    #[Validate('required')]
    public int $yourSchool = 0;

    #[Validate('required')]
    public string $yourPosition = 'A';

    public function render() {
        return view('livewire.auth.school.register');
    }

        /**
     * Register user
     */
    public function register()
    {
        $this->validate();

        try {
            $user = new User;

            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->phone_number = $this->phoneNumber;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->data = [
                'position' => $this->yourPosition,
            ];

            $user->assignRole('School Admin');

            $user->save();

            $user->schools()->attach( $this->yourSchool );

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('auth' );
        } catch (Exception $e) {
            toast()
                ->warning($e->getMessage())
                ->push();
        }
    }
}
