<?php

namespace App\Livewire\School;

use App\Models\Campus;
use Illuminate\Support\Collection;
use Livewire\Component;

class Campuses extends Component
{

    public Collection $campuses;

    public function mount(){

        $school = session()->get('current_school');

        if( ! $school ){
            return $this->redirect( route( 'school.select_school'  ) );
        }

        if( $school->campuses->count() == 1 ){
            session()->put( 'current_campus', $school->campuses->first() );
            return redirect()->intended( route('school.dashboard') );
        }

        $this->campuses = $school->campuses()->get();

    }

    public function selectCampus( $id ){

        $campus = Campus::find($id);

        if( $campus && $campus->school->users()->where('user_id', auth()->user()->id )->exists() ){
            session()->put( 'current_campus', $campus );
            return redirect()->intended( route('school.dashboard') );
        } else {

            toast()
                ->danger( 'You are not authorized to access this campus.' )
                ->push();

        }


    }

    public function render() {

        return view('livewire.school.campuses');

    }
}
