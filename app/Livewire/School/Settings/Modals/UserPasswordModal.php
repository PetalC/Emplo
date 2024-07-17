<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\School;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserPasswordModal extends Component
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    #[Modelable]
    public $open_modal = true;

    #[Locked]
    public School $school;

    public function render()
    {

        if( $this->open_modal != 'update-your-password' ) {
            return '<div></div>';
        }

        return view('livewire.school.settings.modals.user-password-modal');
    }

    public function submitForm()
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|different:currentPassword',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the current password matches
        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        // Reset input fields
        $this->reset(['currentPassword', 'newPassword', 'confirmPassword']);

        // Show success message or perform any other action
        session()->flash('message', 'Password changed successfully!');
    }
}
