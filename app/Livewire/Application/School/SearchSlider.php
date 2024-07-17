<?php

namespace App\Livewire\Application\School;

use App\Models\Campus;
use Livewire\Component;

class SearchSlider extends Component
{
//    public string|null $search_value = null;

//    public function updatedSearchValue(){
//        $this->dispatch('onContentChanged' );
//        $this->render();
//    }

    public function render() {

        $query = Campus::query();

//        if ($this->search_value) {
//            $query->whereHas('primary_profile', function($query) {
//                $query->where('name', 'like', '%' . $this->search_value . '%');
//            } );
//        }

        $campuses = $query->take(10)->get();

        return view('livewire.application.school.search-slider')->with([
            'campuses' => $campuses
        ] );

    }
}
