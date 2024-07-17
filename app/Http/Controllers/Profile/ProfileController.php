<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {

    /**
     * Seen when a user views their own profile
     */
    public function index(){
        return view('profile.index');
    }

    /**
     * Seen when a user edits their own profile
     */
    public function edit(){
        return view('profile.edit');
    }

    /**
     * Seen when a user views their own applications
     */
    public function applications(){
        return view('profile.applications');
    }

    /**
     * Seen when a user views their followed schools
     */
    public function schools(){
        return view('profile.schools');
    }

    /**
     * Seen when a user views their saved / bookmarked jobs
     */
    public function jobs(){
        return view('profile.jobs' );
    }

    /**
     * Seen when a user views another user's profile
     */
    public function view( User $user ){
        // $this->authorize('view', $user ); //this should lock the users account unless there is a connection.
        // The user must have Applied to or openly followed the school for the school staff to view the profile
        // If the user has discreetly followed the school, the school staff should only be able to see the discreet profile mockup
        return view('profile.view' )->with([
            'user' => $user
        ]);
    }

}
