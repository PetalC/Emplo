<?php

namespace App\Livewire\Application;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Registrations extends Component
{

    public Application $application;
    public Collection $user_certifications;

    public function mount( Application $application )
    {
        $this->application = $application;
        $this->user_certifications = $this->application->user->certifications;
    }

    public function render()
    {
        return view('livewire.application.registrations');
    }
}
