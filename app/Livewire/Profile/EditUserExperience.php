<?php

namespace App\Livewire\Profile;

use App\Models\Experience;
use Carbon\Carbon;
use Livewire\Component;

class EditUserExperience extends Component {

    public Experience $experience;

    public string $company;
    public string $role;
    public string $story;
    public  $started_at;
    public  $ended_at;

    protected $rules = [
        'company' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'story' => 'required|string|max:255',
        'started_at' => 'required|string',
        'ended_at' => 'required|string',
    ];

    public function deleteExperience(){

        //$this->>authorize('delete', $this->experience);

        $this->experience->delete();

        $this->dispatch( 'experience_updated' )->to( EditProfile::class );

    }

    public function mount( Experience $experience ){

        $this->experience = $experience;

        $this->company = $experience->company;
        $this->role = $experience->role;
        $this->story = $experience->story;
        $this->started_at = $experience->started_at?->format('M Y') ?? Carbon::now()->format('j/n/Y');
        $this->ended_at = $experience->ended_at?->format('M Y') ?? Carbon::now()->format('j/n/Y');

    }

    public function updated( $field, $value ){

//        dump( $field, $value );
        $this->validateOnly( $field );

        if( $field == 'started_at' || $field == 'ended_at' ){
            $value = Carbon::createFromFormat( 'j/n/Y', $value );
        }

        $this->experience->update( [
            $field => $value
        ] );

        $this->dispatch( 'experience_updated' )->to( EditProfile::class );

    }

    public function render() {
        return view('livewire.profile.edit-user-experience');
    }

}
