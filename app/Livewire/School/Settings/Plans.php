<?php

namespace App\Livewire\School\Settings;

use App\Mail\Subscription\SubscriptionChanged;
use App\Models\Plan;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Illuminate\Support\Collection;
use LucasDotVin\Soulbscription\Models\Subscription;

class Plans extends Component
{

    #[Locked]
    public Collection|null $plans = null;

    #[Locked]
    public Subscription|null $subscription = null;

    #[Locked]
    public School|null $school = null;


    public function mount() {

        if( Auth::check() && session()->has('current_school') ) {
            $school = session()->get('current_school');
            if( $school ){
                $school->load('subscription');
                $this->school = $school;
                $this->subscription = $school->subscription;
            }
        }

        $this->plans = Plan::query()->orderBy( 'order' )->get();

    }

    /**
     * Change the currently subscribed plan.
     *
     * @TODO Implement pending plan change management.
     *
     * @param $plan_id
     * @return void
     */
    public function switchPlan( $plan_id ) {

        /**
         * @var School $school
         */
        $school = Session::get('current_school' );

        if( $school && $school->users()->where( 'users.id', '=', auth()->user()->id )->exists() ){

            $prev_subscription = $school->subscription;

            if( ! $prev_subscription ){
                $school->subscribeTo( Plan::find( $plan_id ) );
            } else {
                $school->switchTo( Plan::find( $plan_id ) );
            }

            $school = School::find( $school->id )->with('subscription')->first();
            Session::put('current_school', $school );

            //Send a notification email
            Mail::to( env( 'CONTACT_EMAIL' ) )->send( new SubscriptionChanged( $school, $prev_subscription ) );

            //@TODO Trigger an event for other parts of the app to listen to.

            $this->mount();
            $this->render();

        } else {
            toast()->danger( 'An error has occurred. Please try again.' )->pushOnNextPage();
            return $this->redirect( route( 'school.select_school' ) );
        }

    }

    public function render() {
        return view('livewire.school.settings.plans');
    }

}
