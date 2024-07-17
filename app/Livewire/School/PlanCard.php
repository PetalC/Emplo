<?php

namespace App\Livewire\School;

use App\Enums\PlanNames;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use LucasDotVin\Soulbscription\Models\Plan;
use LucasDotVin\Soulbscription\Models\Subscription;
use Livewire\Attributes\Reactive;

class PlanCard extends Component {

    public Plan $plan;

    public Collection|array|null $previous_features = null;

    #[Reactive]
    public Subscription|null $subscription = null;

    public $icon;

    #[Reactive]
    public bool $active = false;

    public function mount(){

        if( ! is_a( $this->previous_features, Collection::class ) ){
            $this->previous_features = collect( $this->previous_features );
        }

        if( Auth::check() ){

            $current_school = Session::get('current_school');

//            $this->active = $this->subscription?->plan_id == $this->plan->id;

        }

        switch( $this->plan->name ){
            case PlanNames::SHOWCASE->value:
                $this->icon = 'user';
                break;
            case PlanNames::ATTRACT->value:
                $this->icon = 'users';
                break;
            case PlanNames::ENHANCE->value:
                $this->icon = 'bolt';
                break;
            case PlanNames::SAFEGUARD->value:
                $this->icon = 'shield-check';
                break;
        }

    }

    public function render() {
        return view('livewire.school.plan-card');
    }

}
