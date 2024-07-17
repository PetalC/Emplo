<?php

namespace App\Livewire\Application\Ats\Modals;

use App\Models\Job;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AtsModals extends Component {

    #[Locked]
    public Job $job;

    public bool|string $open_modal = false;

    public mixed $params = null;

    #[On('ats.open-modal')]
    public function openModal( string $modal, mixed $params = null ){
        $this->params = json_decode( $params );
        $this->open_modal = $modal;
    }

    public function render() {
        return view('livewire.application.ats.modals.ats-modals' )->with([
            'open_modal' => $this->open_modal,
        ]);
    }

}
