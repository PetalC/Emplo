<?php

namespace App\Livewire\JobCenter;

use App\Models\Job;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class JobCard extends Component {

    #[Modelable]
    public bool|null $selected = false;

    public Job $job;

    public function render() {
        return view('livewire.job-center.job-card');
    }

}
