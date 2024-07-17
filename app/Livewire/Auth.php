<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Auth extends Component {

    #[Url( as: 'school')]
    public bool $role = false;

    public function mount(){

        if( auth()->check() ){

            if( auth()->user()->can( 'school.view-dashboard' ) ){
                $this->redirect( route( 'school.dashboard' ) );
            } else {
                $this->redirect( route( 'profile' ) );
            }

        }

    }

    #[Layout('layouts.app')]
    public function render() {
        return view('livewire.auth');
    }

}
