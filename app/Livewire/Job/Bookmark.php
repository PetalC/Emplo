<?php

namespace App\Livewire\Job;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Bookmark extends Component {

    public Job $job;

    public bool $is_bookmarked = false;

    public function mount(){
        $this->is_bookmarked = Auth::check() && Auth::user()->saved_jobs()->where( 'id', $this->job->id )->exists();
    }

    public function updated( $field, $value ){

        if( $field === 'is_bookmarked' ){
            if( $value ){
                if( Auth::check() ){
                    Auth::user()->saved_jobs()->attach( $this->job->id );
                }else{
                    $this->redirect( route('auth', [ 'ref' => 'bookmark' ] ) );
                }
            }else{
                Auth::user()->saved_jobs()->detach( $this->job->id );
            }

            $this->dispatch( 'saved_jobs_updated' );

        }

    }

    public function render() {
        return view('livewire.job.bookmark');
    }

}
