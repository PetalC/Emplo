<?php

namespace App\Livewire\School;

use App\Enums\JobStatus;
use App\Models\Application;
use App\Models\Campus;
use App\Models\Interview;
use App\Models\Job;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class JobCenter extends Component {

    use WithPagination;

    #[Locked]
    public School $school;

    #[Locked]
    public Campus $campus;

    #[Locked]
    public JobStatus $status = JobStatus::OPEN;

    public array $selected_jobs = [];

    public bool $should_select_all = false;

    public bool $should_unselect_all = false;

    public function mount(){

//        $school = Session::get('current_school' );
        $campus = Session::get('current_campus' );

        if( ! $campus ){
            return $this->redirect( route('school.select_school') );
//            abort(403);
        }

        $this->campus = $campus;

    }

    public function select_all(){
        $this->should_select_all = true;
    }

    public function unselect_all(){
        $this->should_unselect_all = true;
    }

    public function duplicateSelectedAds() {

        // Check if the user has the required permission
        if (!auth()->user()->can('school.manage-jobs')) {
            session()->flash('error', 'You do not have permission to perform this action.');
            return;
        }

        $jobs = Job::query()->whereIn('id', array_keys($this->selected_jobs))->get();

        foreach ($jobs as $job) {
            $new_job = $job->replicate([
                'uuid'
            ]);
            $new_job->title = $job->title . ' (Copy)';
            $new_job->uuid = Str::uuid();
            $new_job->url_slug = null;
            $new_job->status = JobStatus::DRAFT;
            $new_job->save();

            // Duplicate the jobs specialisation subjects.
            $new_job->subjects()->sync($job->subjects->pluck('id'));
        }

        session()->flash('success', 'Jobs cloned successfully.');

        $this->selected_jobs = [];

        //Adding a redirect to draft jobs to show the new copies
        return $this->redirect( route('school.jobcenter.draft') );

    }

    public function removeSelectedAds() {

        // Check if the user has the required permission
        if (!auth()->user()->can('school.manage-jobs')) {
            session()->flash('error', 'You do not have permission to perform this action.');
            return;
        }

        Job::query()->whereIn('id', array_keys($this->selected_jobs))->update([
            'status' => JobStatus::CANCELLED
        ]);

        session()->flash('success', 'Selected ads removed successfully.');
//        $this->redirect(route('school.jobcenter.index' ) );
        $this->selected_jobs = [];
    }

    public function render() {

        $job_query = $this->campus->jobs()->orderBy('created_at', 'desc')->where('status', '=', $this->status );

        $jobs = $job_query->paginate(10);

//        SELECT * FROM interviews WHERE application_id IN (
//            SELECT id FROM applications WHERE job_id IN (SELECT id FROM jobs WHERE school_id = :schoolId AND campus_id = :campusId)
//)

        $interview_collection = Interview::query()->whereBetween( 'scheduled_at', [Carbon::now(), Carbon::now()->addWeek()] )
            ->whereHas( 'application', function( Builder $builder ) {
                return $builder->whereHas('campus', function (Builder $builder) {
                    $builder->where('id', $this->campus->id);
                });
            });

        $panel_member_ids = $interview_collection->pluck('panel_members')->flatten()->unique();

        // Unfortunately we need to get the names separately to the interviews
        $interview_panel_names = User::query()->whereIn('id', $panel_member_ids)->pluck(DB::raw('CONCAT(first_name, " ", last_name)'), 'id')->toArray();
//
        $interviews = $interview_collection->get();

        if( $this->should_select_all ){
            $this->selected_jobs = array_fill_keys( $jobs->pluck('id')->toArray(), true );
            $this->should_select_all = false;
        }

        if( $this->should_unselect_all ){
            $this->selected_jobs = [];
            $this->should_unselect_all = false;
        }

        return view('livewire.school.job-center')->with([
            'jobs' => $jobs,
            'interviews' => $interviews,
            'interview_panel_names' => $interview_panel_names
        ]);
    }

}
