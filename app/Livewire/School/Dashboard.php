<?php

namespace App\Livewire\School;

use App\Enums\ApplicationStatuses;
use App\Enums\JobStatus;
use App\Models\Campus;
use App\Models\Job;
use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Dashboard extends Component
{

    public Campus|null $campus = null;

//    $this->

    public array $stats = [];

    public function mount() {

        $campus = Session::get('current_campus' );

        if( ! $campus ){
            return $this->redirect( route( 'school.campuses') );
        }

        $campus->load( [ 'jobs', 'primary_profile', 'school', 'followers' ] );

        $jobs = Job::query()->where( 'campus_id', $campus->id );

        $applied_jobs = $jobs->withCount('applications' )->get();

        $this->stats['job_count'] = $jobs->count();
        $this->stats['follower_count'] = $campus->followers->count();
        $this->stats['applicant_count'] = $applied_jobs->sum('applications_count');
        $this->stats['hired_count'] = 0;

//        $jobs->with( 'applications', function ( $query ) {
//            $query->where('status', ApplicationStatuses::STATUS_HIRED );
//        } )->count();

        $open_jobs = $jobs->where('status', JobStatus::OPEN );

        $this->stats['total_vacancies'] = $open_jobs->count();
        $this->stats['teaching_vacancies'] = $open_jobs->whereHas( 'subjects', function( Builder $query ){
            $query->whereNotIn('name', [
                'Accounting',
                'Business Administration',
                'Agricultural Science',
                'Arabic',
                'Armenian',
                'Art and Visual Art',
                'Arts Technician',
                'Biology',
                'Boarding Supervisor',
                'Head of Boarding House',
                'Head of Boarding',
                'Building and Construction',
                'Bus Driver',
                'Business Manager',
            ]);
        })->count();

        $this->stats['non_teaching_vacancies'] = $open_jobs->whereHas( 'subjects', function( Builder $query ){
            $query->whereIn('name', [
                'Accounting',
                'Business Administration',
                'Agricultural Science',
                'Arabic',
                'Armenian',
                'Art and Visual Art',
                'Arts Technician',
                'Biology',
                'Boarding Supervisor',
                'Head of Boarding House',
                'Head of Boarding',
                'Building and Construction',
                'Bus Driver',
                'Business Manager',
            ]);
        })->count();

        $this->stats['total_staff'] = $campus->primary_profile?->staff_size ?? 0;
        $this->stats['teaching_staff'] = $campus->primary_profile?->teacher_size ?? 0;
        $this->stats['non_teaching_staff'] = $campus->primary_profile?->staff_size ?? 0 - $campus->primary_profile?->teacher_size ?? 0;

        $this->stats['staff_req_total_percentage'] = $this->stats['total_staff'] ? number_format( $this->stats['total_vacancies'] / $this->stats['total_staff'] * 100, 2 ) : 0;
        $this->stats['staff_req_teacher_percentage'] = $this->stats['total_staff'] ? number_format($this->stats['teaching_staff'] / $this->stats['total_staff'] * 100,2 ) : 0;
        $this->stats['staff_req_non_teacher_percentage']  = $this->stats['total_staff'] ? number_format($this->stats['non_teaching_staff'] / $this->stats['total_staff'] * 100, 2 ) : 0;

//        $this->authorize('view', $campus );

        $this->campus = $campus;

    }

    public function render() {
        return view('livewire.school.dashboard');
    }

}
