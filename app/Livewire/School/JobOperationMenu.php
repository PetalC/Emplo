<?php

namespace App\Livewire\School;

use Livewire\Component;

class JobOperationMenu extends Component
{
    public $selectedItem = 3;
    
    public function selectItem($newValue)
    {
        $this->selectedItem = $newValue;
    }

    public function render()
    {
        return view('livewire.school.job-operation-menu');
    }
}
