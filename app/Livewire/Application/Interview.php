<?php

namespace App\Livewire\Application;

use App\Models\Application;
use App\Models\Job;
use Livewire\Component;

class Interview extends Component
{

    public Application $application;

    public function mount( Application $application )
    {
        $this->application = $application;
    }

    public function scheduleInterview() {
        $this->parent->scheduleInterview();
    }

    public function render()
    {
        return view('livewire.application.interview');
    }
}
