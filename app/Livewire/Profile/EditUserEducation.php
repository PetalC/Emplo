<?php

namespace App\Livewire\Profile;

use App\Models\Education;
use App\Models\Experience;
use Carbon\Carbon;
use Livewire\Component;

class EditUserEducation extends Component {

    public Education $education;

    public string $school;
    public string $degree;
    public string $story;
    public  $started_at;
    public  $ended_at;

    protected $rules = [
        'school' => 'required|string|max:255',
        'degree' => 'required|string|max:255',
        'story' => 'required|string|max:255',
        'started_at' => 'required|string',
        'ended_at' => 'required|string',
    ];

    public function deleteEducation(){

        //$this->>authorize('delete', $this->education);

        $this->education->delete();

        $this->dispatch( 'education_updated' )->to( EditProfile::class );

    }

    public function mount( Education $education ){

        $this->education = $education;

        $this->school = $education->school;
        $this->degree = $education->degree;
        $this->story = $education->story;
        $this->started_at = $education->started_at?->format('M Y') ?? Carbon::now()->format('j/n/Y');
        $this->ended_at = $education->ended_at?->format('M Y') ?? Carbon::now()->format('j/n/Y');

    }

    public function updated( $field, $value ){

//        dump( $field, $value );
        $this->validateOnly( $field );

        if( $field == 'started_at' || $field == 'ended_at' ){
            $value = Carbon::createFromFormat( 'j/n/Y', $value );
        }

        $this->education->update( [
            $field => $value
        ] );

        $this->dispatch( 'experience_updated' )->to( EditProfile::class );

    }

    public function render() {
        return view('livewire.profile.edit-user-education');
    }

}
