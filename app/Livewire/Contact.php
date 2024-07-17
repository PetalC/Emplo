<?php

namespace App\Livewire;

use App\Mail\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Contact extends Component
{

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $phone = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|max:255')]
    public string $school = '';

    #[Validate('required|string|max:2000')]
    public string $message = '';

    public bool $is_sent = false;

    public function submitContactRequest(){

        $this->validate();

        Mail::to(env( 'CONTACT_EMAIL', 'ben.casey@humanpixel.com.au' ) )->send( new ContactRequest( [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'school' => $this->school,
            'message' => $this->message,
        ] ) );

        $this->is_sent = true;

        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->school = '';
        $this->message = '';

    }

    public function render() {
        return view('livewire.contact');
    }
}
