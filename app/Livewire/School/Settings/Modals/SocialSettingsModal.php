<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\School;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SocialSettingsModal extends Component
{

    #[Modelable]
    public $open_modal = true;

    #[Locked]
    public School $school;

    public string $facebook = '';

    public string $linkedin = '';

    public string $instagram ='';

    public function rules(){
        return [
            'facebook' => 'string',
            'instagram' => 'string',
            'linkedin' => 'string',
        ];
    }

    public function mount( School $school )
    {
        $this->school = $school;

        $this->facebook = $this->school->settings->facebook;
        $this->linkedin = $this->school->settings->linkedin;
        $this->instagram = $this->school->settings->instagram;

    }


    public function submitForm(){

        $this->validate();

        $this->school->settings->facebook = $this->facebook;
        $this->school->settings->linkedin = $this->linkedin;
        $this->school->settings->instagram = $this->instagram;

        // Save the settings
        $this->school->settings->save();

        // Update the session
        session()->put( 'current_school', $this->school );

    }


    public function render()
    {

        if( $this->open_modal != 'social-media' ) {
            return '<div></div>';
        }

        return view('livewire.school.settings.modals.social-settings-modal');
    }
}
