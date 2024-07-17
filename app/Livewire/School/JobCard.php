<?php

namespace App\Livewire\School;

use App\Models\Job;
use Livewire\Component;

class JobCard extends Component
{

    public Job $job;

    public function mount(Job $job)
    {
        $this->job = $job;
    }
    public function render()
    {
        return view('livewire.school.job-card');
    }
}
