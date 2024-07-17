<?php

namespace App\Livewire\School;

use App\Models\School;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SettingCard extends Component
{

    public array $setting;

    #[Locked]
    public School $school;

    public ?array $social_profiles = [
        'facebook' => '',
        'linkedin' => '',
        'instagram' => '',
    ];

    public function mount(array $setting)
    {
        $school = Session::get('current_school' );

        if( ! $school ){
            return $this->redirect( route('school.select_school') );
        }

        $this->school = $school;
        $this->setting = $setting;
    }

    public function render()
    {
        return view('livewire.school.setting-card');
    }
}
