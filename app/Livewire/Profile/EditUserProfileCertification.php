<?php

namespace App\Livewire\Profile;

use App\Models\Experience;
use App\Models\UserProfileCertification;
use Carbon\Carbon;
use Livewire\Component;

class EditUserProfileCertification extends Component {

    public UserProfileCertification $profile_certification;

    public string|null $institution;
    public string|null $certification;
    public string|null $description;
    public mixed $completed_at;

//'user_id',
//*
//* 'institution',
//* 'certification',
//* 'description'
//* 'completed_at',

    protected $rules = [
        'institution' => 'required|string|max:255',
        'certification' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'completed_at' => 'required|string',
    ];

    public function deleteCertification(){

        //$this->authorize('delete', $this->profile_certification);

        $this->profile_certification->delete();

        $this->dispatch( 'profile_certification_updated' )->to( EditProfile::class );

    }

    public function mount( UserProfileCertification $profile_certification ){
//
//        dd( $certification );

        $this->profile_certification = $profile_certification;

        $this->institution = $profile_certification->institution;
        $this->certification = $profile_certification->certification;
        $this->description = $profile_certification->description;
        $this->completed_at = $profile_certification->completed_at?->format('M Y') ?? Carbon::now()->format('j/n/Y');

    }

    public function updated( $field, $value ){

        $this->validateOnly( $field );

        if( $field == 'completed_at' ){
            $value = Carbon::createFromFormat( 'j/n/Y', $value );
        }

        $this->profile_certification->update( [
            $field => $value
        ] );

        $this->dispatch( 'profile_certification_updated' )->to( EditProfile::class );

    }

    public function render() {
        return view('livewire.profile.edit-user-profile-certification');
    }

}
