<?php

namespace App\Livewire\Search;

use App\Models\Job;
use Livewire\Component;

class JobCard extends Component {

    public Job $job;

    public function render() {
        return view('livewire.search.job-card');
    }

}
