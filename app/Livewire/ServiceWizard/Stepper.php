<?php

namespace App\Livewire\ServiceWizard;

use Livewire\Component;

class Stepper extends Component
{
    public function render()
    {
        return view('livewire.service-wizard.stepper');
    }

    public $progress = 1;
    public $step = 1;

    protected $listeners = ['progressUpdated'];

    public function progressUpdated($newValue)
    {
        $this->step = $newValue;
        $this->progress = $newValue == 1 ? 1 : ($newValue <= 4 ? 2 : 3);
    }
}
