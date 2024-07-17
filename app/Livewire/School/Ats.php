<?php

namespace App\Livewire\School;

use App\Enums\ApplicationStatuses;
use App\Enums\CitizenshipTypes;
use App\Enums\ApplicationReviewStatuses;
use App\Models\Application;
use App\Models\City;
use App\Models\Country;
use App\Models\Job;
use App\Models\State;
use App\Nova\CitizenshipType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

/**
 * Parent component for the application management
 */
class Ats extends Component
{

    #[Locked]
    public Collection $countries;

    #[Locked]
    public Collection $states;

    public Collection $applications;

    public Job $job;

    public int $unfiltered_total;

    public array $filters = [
        'australian-citizen-resident' => false,
        'teacher-registration' => false,
        'subject-match' => false,
        'references-provided' => false,
        'references-confirmed' => false,
        'saved-referees' => false,
        'panel-selection' => false,
        'suitability-declaration' => false,
    ];

    // Force child component to reload when filter has changed
    #[Locked]
    public string $filterKey = 'initial';

    public function mount(Job $job = null) {
        $this->job = $job;
        $this->countries = Country::all()->pluck( 'name', 'id' );
        $this->states = State::all()->pluck( 'name', 'id' );
    }

    #[On('update_ats_table')]
    public function refreshTable(){
        $this->render();
    }

    public function updatedFilters()
    {
        foreach ($this->filters as $key => $value) {
            if ($value === '') {
                $this->filters[$key] = null;
            }
        }
    }

    public function render() {

        //$query = Application::query()->with(['user','user.profile']);
        $query = Application::query()->with(['user','user.profile']);
        $query->where('job_id', '=', $this->job->id);

        // Filter out inaccessible applications
        $query->whereNotIn('status', [
            ApplicationStatuses::STATUS_DRAFT, // not yet submitted by applicant
            ApplicationStatuses::STATUS_WITHDRAWN // soft deleted by applicant
        ] );

        $this->unfiltered_total = $query->count();

        $the_job = $this->job;

        foreach($this->filters as $type => $value){
            switch($type){
                case 'australian-citizen-resident':
                    if($value) {
                        $query->whereHas(
                            'user.profile',
                            function (Builder $q) {
                                // AUS Citizen or PR
                                $q->whereIn('citizenship_id', ['1,2']);
                            }
                        );
                    }
                    break;
                case 'teacher-registration':
                    if($value) {
                        $query->whereHas(
                            'user.certifications',
                            function (Builder $q) use ($the_job) {
                                $q->where('is_valid', true)
                                    ->where('certification', $the_job->licencing_authority);

                            }
                        );
                    }
                    break;
                case 'subject-match':
                    if($value) {
                            $query->whereHas('user.subjects', function (Builder $q) use ($the_job) {
                                $q->whereIn('subjects.id', $the_job->subjects->pluck('id'));
                            });
                    }
                    break;
                case 'references-provided':
                    if($value) {
                            $query->whereHas('reference_checks');
                    }
                    break;
                case 'references-confirmed':
                    if($value) {
                            $query->whereHas('reference_checks', function (Builder $q) use ($the_job) {
                                $q->whereNotNull('completed_at');
                            });
                    }
                    break;
                case 'saved-referees':
                    if($value){
                        $query->whereHas('user.referees');
                    }
                    break;
                case 'panel-selection':
                    if($value) {
                        $query->whereHas(
                            'reviews',
                            function (Builder $q) use ($the_job) {
                                $q->where('status', ApplicationReviewStatuses::APPROVED->value);
                            }
                        );
                    }
                    break;
                case 'suitability-declaration':
                    if($value) {
                        $query->whereHas(
                            'user.profile',
                            function (Builder $q) {
                                $q->where('suitable_for_work', true);
                            }
                        );
                    }
                    break;
            }
        }

        $fieldSql = 'FIELD(status, '.
            DB::getPdo()->quote(ApplicationStatuses::STATUS_SUBMITTED->value).', '.
            DB::getPdo()->quote(ApplicationStatuses::STATUS_SHORTLISTED->value).', '.
            DB::getPdo()->quote(ApplicationStatuses::STATUS_HIRED->value).')';
        $query->orderByRaw($fieldSql.' DESC');

        // Filter applications based on profile
//        $query->whereHas('user.profile', function ($q) {
//            // State
//            if( isset( $this->filters['state'] ) && ! empty( $this->filters['state'] ) ){
//                $stateOrTerritory = State::find($this->filters['state']);
//                $q->where('state', $stateOrTerritory->name);
//            }
//        });

        // Force the child component to reload based on the filters
        $this->filterKey = json_encode(['this-ats', $this->filters]);

        $query->with('user.profile');

        $this->applications = $query->get();

        return view('livewire.school.ats');
    }
}
