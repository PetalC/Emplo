<?php

namespace App\Livewire\Application;

use App\Models\Application;
use App\Models\Job;
use App\Models\ReferenceCheck;
use Illuminate\Support\Collection;
use Livewire\Component;

class References extends Component
{

    public Application $application;

    /**
     * @var Collection ReferenceCheck[]
     */
    public Collection $completedReferenceChecks;

    public function mount( Application $application )
    {
        $this->application = $application;
        $this->completedReferenceChecks = $this->application->reference_checks()->where('status', 'Completed')->get();
    }

    public function render()
    {
        return view('livewire.application.references');
    }
}
