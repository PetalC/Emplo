<?php

namespace App\Livewire\School;

use Livewire\Component;

class RoleCard extends Component
{
    public $closed = false;

    public function render()
    {
        return view('livewire.school.role-card');
    }
}
