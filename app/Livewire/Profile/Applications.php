<?php

namespace App\Livewire\Profile;

use App\Enums\ApplicationStatuses;
use Livewire\Attributes\On;
use Livewire\Component;

class Applications extends Component {

    #[On('applications_updated')]
    public function render() {
        return view('livewire.profile.applications', [
            'applications' => auth()->user()->applications()->where( 'status', '!=', ApplicationStatuses::STATUS_WITHDRAWN )->whereHas( 'job' )->get()
        ]);
    }

}
