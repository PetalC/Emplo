<?php

namespace App\Livewire\School;

use App\Enums\LicencingAuthorityTypes;
use App\Enums\SchoolFollowerType;
use App\Models\Campus;
use App\Models\City;
use App\Models\Country;
use App\Models\CitizenshipType;
use App\Models\School;
use App\Models\CampusFollower;
use App\Models\State;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Staffroom extends Component
{


    #[Locked]
    public Collection $countries;

    #[Locked]
    public Collection $states;

    #[Locked]
    public Collection $cities;

//    #[Locked]
//    public array $candidateTypes = [
//        1 => 'Open Follower',
//        2 => 'Discreet Follower',
//        3 => 'Applied',
//        4 => 'Applied Hired',
//    ];

    #[Locked]
    public array $candidateTypes = [];

    #[Locked]
    public Collection $right_to_work_options;

    #[Locked]
    public array $supply_reference_options = [
        'yes' => 'Yes',
        'no' => 'No',
    ];

    #[Locked]
    public array $specialisation_options;

    #[Locked]
    public array $registration_options;

    public Campus $campus;

    public array $filters = [
        'state' => null,
        'city' => null,
        'country' => null,
        'candidateType' => null,
        'rtw' => null,
        'supply_reference' => null,
        'selected_subjects' => [],
        'registered_with' => []
    ];

    public array $selected_users = [];

    public array $authority_types = [];

    private bool $should_select_all = false;
    private bool $should_select_none = false;

    public array $debug;

    public function mount() {

//        $this->school = $school;
        $this->debug = [];

        $this->countries = Country::all()->pluck( 'name', 'id' );
        $this->specialisation_options = Subject::all()->pluck( 'name', 'id' )->toArray();

        $this->right_to_work_options = CitizenshipType::all()->pluck('name','id');

        $this->authority_types = LicencingAuthorityTypes::cases();

        $this->candidateTypes = SchoolFollowerType::cases();

    }

    public function updatedFilters() {
        foreach ($this->filters as $key => $value) {
            if ($value === '') {
                $this->filters[$key] = null;

                if($key === 'country'){
                    // If the country has been changed reset the state / city lists too
                    $this->filters['state'] = null;
                    $this->filters['city'] = null;
                }

                if($key === 'state'){
                    // If the country has been changed reset the   city lists too
                    $this->filters['city'] = null;
                }
            }
        }
    }

    public function updatedFiltersCountry($newCountryId) {
        $this->states = State::where('country_id', $newCountryId)->pluck('name', 'id');
        $this->cities = collect([]);
    }

    public function updatedFiltersState($newStateId) {
        $this->cities = City::where('state_id', $newStateId)->pluck('name', 'id');
    }

    public function selectAllUsers(){
        $this->should_select_all = true;
        $this->should_select_none = false;
    }

    public function unselectAllUsers(){
        $this->should_select_all = false;
        $this->should_select_none = true;
    }

    public function render() {

        $query = $this->campus->followers()
            ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
            ->select('users.*')
            ->selectRaw("ST_Distance(user_profiles.location, POINT(?, ?)) as distance", [
                $this->campus->primary_profile->longitude, $this->campus->primary_profile->latitude
            ])
            ->with('profile');

        if( $this->filters['country'] || $this->filters['state'] || $this->filters['city'] ){

            $query->whereHas('profile', function ( Builder $q ) {

                if( $this->filters['country'] ){
                    $q->where('country', Country::find($this->filters['country'])->name);
                }

                if( $this->filters['state'] ){
                    $q->where('state', State::find($this->filters['state'])->name);
                }

                if( $this->filters['city'] ){
                    $q->where('city', City::find($this->filters['city'])->name);
                }

            });

        }

        $selectedSubjects = $this->filters['selected_subjects'];

        if(!empty($selectedSubjects)) {
            $query->whereHas('subjects', function ($q) use ($selectedSubjects) {
                $q->whereIn('user_taxonomies.taxonomy_id', array_keys($selectedSubjects));
            });
        }

        $registeredWith = $this->filters['registered_with'];

        if(!empty($registeredWith)) {
            $query->whereHas('certifications', function ($q) use ($registeredWith) {
                $q->whereIn('user_certifications.certification', array_values($registeredWith));
            });
        }

        if(isset($this->filters['supply_reference'])) {
            if ($this->filters['supply_reference'] === 'yes') {
                $query->whereHas('referees');
            } elseif ($this->filters['supply_reference'] === 'no') {
                $query->whereDoesntHave('referees');
            }
        }

        if(isset($this->filters['candidateType'])) {
            $query->where('type','=', $this->filters['candidateType']);
        }

        if( $this->should_select_all ){
            $ids = $query->pluck('user.id');
            foreach( $ids as $id ){
                $this->selected_users[$id] = true;
            }
        } elseif( $this->should_select_none ){
            $this->selected_users = [];
        }

        return view('livewire.school.staffroom')->with( [
            'followers' => $query->paginate(20),
            'campus' => $this->campus,
        ] );
    }
}
