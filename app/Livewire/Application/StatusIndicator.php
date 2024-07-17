<?php

namespace App\Livewire\Application;

use App\Models\Application;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class StatusIndicator extends Component {

    #[Locked]
    #[Reactive]
    public Application $application;

//    public function mount() {}

    public function render() {
        return view('livewire.application.status-indicator');
    }

}
