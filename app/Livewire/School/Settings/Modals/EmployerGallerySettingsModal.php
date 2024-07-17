<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\School;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class EmployerGallerySettingsModal extends Component
{

    #[Modelable]
    public $open_modal = true;

    #[Locked]
    public School $school;

    public function mount(School $school)
    {
        $this->school = $school;
    }

    public function rules(){
        return [
            'facebook' => 'string',
        ];
    }

    public function submitForm()
    {
        $this->validate();
    }

    public function render()
    {
        if ($this->open_modal != 'employer-gallery') {
            return '<div></div>';
        }

        return view('livewire.school.settings.modals.employer-gallery-settings-modal');
    }

}
