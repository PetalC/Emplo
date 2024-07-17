<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class SavedJobs extends Component {

    #[On('saved_jobs_updated')]
    public function handle_refresh(){
        $this->render();
    }

    public function render() {
        return view('livewire.profile.saved-jobs', [
            'jobs' => auth()->user()->saved_jobs
        ]);
    }
}
