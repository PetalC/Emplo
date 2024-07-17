<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class Search extends Component {

    #[Url( 'schools' )]
    public bool $show_schools = false;

    #[Url( 'search' )]
    public string|null $search_value = null;

    public function render() {
        return view('livewire.search' );
    }

}
