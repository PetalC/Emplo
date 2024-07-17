<?php

namespace App\Livewire;

use App\Enums\JobStatus;
use App\Models\Advert;
use App\Models\Job;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Candidates extends Component {

    #[Layout('layouts.app')]
    public function render() {
        return view('livewire.candidates', [
//            'jobs' => Job::query()->where( 'status', JobStatus::OPEN )->latest()->paginate(10),
        ]);
    }

}
