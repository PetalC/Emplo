<?php

namespace App\Livewire\ServiceWizard;

use Livewire\Component;

class SecondStep extends Component
{
    public function updateParentValue($newValue)
    {
        $this->dispatch('progressUpdated', $newValue);
    }
    public function render()
    {
        return view('livewire.service-wizard.second-step');
    }
}
