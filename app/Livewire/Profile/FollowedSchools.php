<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class FollowedSchools extends Component {

    #[On('followed_campuses_updated')]
    public function handle_refresh(){
        $this->render();
    }

    public function render() {
        return view('livewire.profile.followed-schools', [
            'campuses' => auth()->user()->followed_schools
        ] );
    }

}
