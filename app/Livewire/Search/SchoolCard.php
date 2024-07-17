<?php

namespace App\Livewire\Search;

use App\Livewire\Dashboard\Locked;
use App\Models\Campus;
use Livewire\Component;

class SchoolCard extends Component {

    /**
     * school model
     */
    #[Locked]
    public Campus $campus;

    public function render() {
        return view('livewire.search.school-card');
    }

}
