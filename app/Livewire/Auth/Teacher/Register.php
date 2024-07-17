<?php

namespace App\Livewire\Auth\Teacher;

use App\Models\Subject;
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

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    #[Validate('required|same:password')]
    public string $password2 = '';

    #[Validate('required')]
    public string $rightWorkInAU = 'Yes';

    #[Validate('required')]
    public string $occupation = 'Teaching';

    public array $current_occupation_options = [
        'Teaching',
        'Studying',
        'Non-Teaching role (school based)',
        'Middle Management (school based)',
        'Senior Leadership (school based)',
        'Principal (school based)',
        'I am not working in a School',
    ];

    #[Validate('accepted')]
    public bool $acceptTOS = false;

    public array $selected_specialities = [];

    public array $specialities_options = [];

    public function mount(){
        $this->specialities_options = Subject::all()->pluck('name', 'id' )->toArray();
    }

    public function render()
    {
        return view('livewire.auth.teacher.register');
    }

    /**
     * Register user
     */
    public function register()
    {
        $this->validate();

        try {
            if (! $this->acceptTOS) {
                throw new Exception('Please confirm that you have read and accepted the Terms & Conditions');
            }

            $user = new User;

            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->phone_number = $this->phoneNumber;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->data = [
//                'i_am_currently_in' => $this->location,
                'current_occupation' => $this->occupation,
            ];

            $user->assignRole('Job Seeker');

            $user->save();

            $user->profile()->create([
                'right_to_work' => $this->rightWorkInAU == 'Yes' ? 1 : 0,
            ]);

            if( ! empty( $this->selected_specialities ) ){
                $user->subjects()->attach( array_keys( $this->selected_specialities ) );
            }

            event(new Registered($user));

//            Auth::login($user);

            return redirect()->route('auth');
        } catch (Exception $e) {
//            dd( $e );
            toast()
                ->warning($e->getMessage())
                ->push();
        }
    }
}
