<?php

namespace App\Livewire\Components\Campus;

use App\Enums\SchoolFollowerType;
use App\Models\Campus;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FollowCampusButton extends Component {

    #[Locked]
    public Campus $campus;

    public $shadow = false;

    public $button_variant = 'primary';

    public $alt_button_variant = 'secondary';

    public $button_class = '!text-[10px] !px-3 !py-0.5 mt-2';

    public function follow() {

        $this->campus->followers()->attach( Auth::id(), [
            'type' => SchoolFollowerType::OPEN
        ] );

        $this->dispatch( 'followed_campuses_updated' );

    }

    public function unfollow() {

        $this->campus->followers()->detach( Auth::id() );

        $this->dispatch( 'followed_campuses_updated' );

    }

    public function render() {

        $user = Auth::user();

        // If the user doesn't have a profile then clicking a link to view their profile will error.
        if( $user && $user->profile ){
            return view('livewire.components.campus.follow-campus-button')->with([
                'isFollowing' => $this->campus->followers()->where( 'id', '=', Auth::id() )->exists()
            ]);
        }

        return '<div></div>';

    }
}
