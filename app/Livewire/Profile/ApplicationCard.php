<?php

namespace App\Livewire\Profile;

use App\Enums\ApplicationStatuses;
use App\Models\Application;
use App\Models\Job;
use Livewire\Component;

class ApplicationCard extends Component {

    public Application $application;

    public Job $job;

    public function mount( Application $application ) {
        $this->application = $application;
        $this->job = $this->application->job;
    }

    public function withdraw_application(){
        $this->application->update( [
            'status' => ApplicationStatuses::STATUS_WITHDRAWN
        ] );
        $this->dispatch( 'applications_updated' )->to( Applications::class );
    }

    public function render() {
        return view('livewire.profile.application-card');
    }

}
