<?php

namespace App\Livewire\JobCenter;

use App\Models\Interview;
use Livewire\Component;

class InterviewCard extends Component {

    public Interview $interview;
    public array $panelMemberNames = [];

        public function render() {
        return view('livewire.job-center.interview-card');
    }

}
