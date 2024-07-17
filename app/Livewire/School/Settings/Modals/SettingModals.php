<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\School;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class SettingModals extends Component
{
    public bool|string $open_modal = false;

    #[Locked]
    public School $school;


    #[On('settings.open-modal')]
    public function openModal( string $modal){
        $this->open_modal = $modal;
        $this->render();
    }

    public function mount(){

        $this->school = session()->get('current_school');

        if( ! $this->school ){
            return $this->redirect()->route('school.select_school');
        }

        if (!$this->school->settings()->exists()) {
            $this->school->settings()->create();
            session()->put( 'current_school', $this->school );
        }

    }


    public function render() {

        return view('livewire.school.settings.modals.setting-modals' )->with([
            'open_modal' => $this->open_modal,
        ]);
    }

}
