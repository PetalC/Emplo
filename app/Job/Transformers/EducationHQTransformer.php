<?php
namespace App\Job\Transformers;

use Carbon\Carbon;

class EducationHQTransformer
{
    protected $job;

    public function __construct($job)
    {
        $this->job = $job;
    }
    
    /**
     * Transforms the Job into Education HQ Accepted Data
     *
     */
    public function transform()
    {
        $ehqJob = new \stdClass();
        $school = $this->job->schoolDetails;

        /* Job Contract */
        $jobType = 'C';
        if ($this->job->length == 'Permanent') {
            $jobType = 'P';
        }

        if ($this->job->length == 'Casual') {
            $jobType = 'T';
        }

        /* Add SchoolHouse Link */
        $description = $this->job->description;
        $link = \URL::To('/jobs/'.$this->job->id);
        $schoolhouseLink = "<br/><p><a href='$link'>Click here to visit SchoolHouse</a></p>";
        $description = $this->job->description.$schoolhouseLink;

        $ehqJob->school = $school->name;
        $ehqJob->job_reference = "schoolhouse".$this->job->id;
        $ehqJob->job_title = $this->job->title;
        $ehqJob->job_type = $jobType;
        $ehqJob->job_hours = ($this->job->time_requirement == 'Full-Time') ? 'F' : 'P';
        $ehqJob->job_more_info = \URL::To('/jobs/'.$this->job->id);
        $ehqJob->job_location = $school->country.' / '.$school->state.' / '.$school->city;
        $ehqJob->job_description = $description;
        
        $ehqJob->categories = [];

        /* Position Types */
        $positionType = 'Non-Teaching Positions/Roles';
        if ($this->job->position_type == 'Middle Management') {
            $positionType = 'School Management';
        }

        if ($this->job->position_type == 'Primary Teacher') {
            $positionType = 'Teaching - Primary';
        }

        if ($this->job->position_type == 'Secondary Teacher') {
            $positionType = 'Teaching - Secondary';
        }

        if ($this->job->position_type == 'Senior Leadership') {
            $positionType = 'School Management';
        }

        if ($this->job->position_type == 'Teaching') {
            $positionType = 'Teaching - Primary';
        }

        $category = new \stdClass();
        $category->category_name = $positionType;
        $ehqJob->categories[] = $category;

        /* Job Expires At */
        $expiresAt = new Carbon();
        if ($this->job->expires_at) {
            $expiresAt = new Carbon($this->job->expires_at);    
        }

        $ehqJob->ad_expiry = $expiresAt->format('Y-m-d');

        /* School Type */
        $ehqJob->school_type = $school->classification;
        if ($school->classification == 'International') {
            $ehqJob->school_type = 'Other';
        }

        return $ehqJob;
    }
}