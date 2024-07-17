<?php

namespace App\Livewire\School;

use App\Models\CampusFollower;
use App\Models\User;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class FollowerCard extends Component
{

    public User $user;

    #[Modelable]
    public bool|null $selected = false;

    public function mount()
    {}

    public function render()
    {
        return view('livewire.school.follower-card');
    }
}
