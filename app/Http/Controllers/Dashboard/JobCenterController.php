<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\PlanFeatures;
use App\Enums\VacancyReasons;
use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureCampusIsSetInSession;
use App\Models\Campus;
use App\Models\Job;
use Illuminate\Support\Facades\Session;


class JobCenterController extends Controller {

    public function __construct(){

        $this->middleware(function($request, $next) {
            $school = session()->get('current_school');

            if( ! $school->subscription ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            if( ! $school->hasFeature( PlanFeatures::JOB_CENTER->value ) ) {
                return redirect()->route('school.settings', [ 'subscription_error' => 'true' ] );
            }

            return $next($request);
        });

    }

    public function index(){
        //      $this->authorize( 'view', Job::class )

        return view('school.job-center.index')->with([
            'status' => JobStatus::OPEN
        ]);
    }

    public function closed(){
        //      $this->authorize( 'view', Job::class )

        return view('school.job-center.index')->with([
            'status' => JobStatus::CLOSED
        ]);
    }

    public function draft(){

//      $this->authorize( 'view', Job::class )

        return view('school.job-center.index')->with([
            'status' => JobStatus::DRAFT
        ]);
    }

    public function create(){

        $school = session()->get('current_school');
        $campus = session()->get('current_campus');

        if( ! $campus || ! $school ){
            return redirect()->route('auth' );
        }

        //$this->authorize( 'create', Job::class )

        $job = Job::create( [
            'title' => '',
            'description' => '',
            'responsibilities' => '',
            'required_licences_certs' => '',
            'employment_type' => JobType::FULLTIME,
            'school_id' => $school->id,
            'campus_id' => $campus->id,
            'status' => JobStatus::DRAFT,
            'vacancy_reason' => VacancyReasons::OTHER,
        ] );

        return redirect( route( 'school.jobcenter.edit', $job ) );

    }

    public function edit( Job $job ){

        //$this->authorize( 'update', $job )

        return view('school.job-center.edit')->with([
            'job' => $job
        ]);

    }

}
