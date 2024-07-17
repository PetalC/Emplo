<?php

namespace App\Livewire\School;

use App\Models\School;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectSchool extends Component
{

    public array|Collection $schools = [];

    public function mount() {

        $this->authorize( 'school.view-dashboard' );

        $this->schools = auth()->user()->schools()->get();

//        if( session()->has('current_school') ){
//            session()->forget('current_school');
//        }

        if( session()->has('current_campus') ){
            session()->forget('current_campus');
        }

    }

    public function selectSchool($schoolId) {

        $school = School::find($schoolId);

        if( $school && $school->users()->where('user_id', auth()->user()->id )->exists() ){
            session()->put( 'current_school', $school );
            return redirect()->route('school.dashboard');
        } else {

            toast()
                ->danger( 'You are not authorized to access this school.' )
                ->push();

        }

    }

    public function render()
    {
        return view('livewire.school.select-school');
    }
}
