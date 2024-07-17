<?php

namespace App\Http\Controllers;

use App\Models\CampusProfile;
use App\Models\Job;
use App\Enums\MediaCollections;

class JobController extends Controller
{

    public function __construct() {

        if( request()->route('job') ){

            $job = Job::where( 'id', request()->route('job') )->first();

            if( $job && $job->campus->primary_profile ){
                $job->campus->primary_profile->setColors();
            }

        }

    }

    /**
     * Handle the incoming request.
     */
    public function view(Job $job)
    {

        // Grab documents
        $supporting_documents = $job->getMedia(MediaCollections::JOBCENTRE_JOB_DOCUMENTS->value);

        return view('jobs.view', [
            'job' => $job,
            'supporting_documents' => $supporting_documents
        ]);
    }

    public function apply(Job $job)
    {
        return view('jobs.apply', [
            'job' => $job
        ]);
    }
}
