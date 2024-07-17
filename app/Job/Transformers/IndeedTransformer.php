<?php
namespace App\Job\Transformers;

use Carbon\Carbon;

class IndeedTransformer
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
        $feed = [];
        $school = $this->job->schoolDetails;
        
        $feed['job']['title'] = $this->job->title;
        $feed['job']['date'] = date('D, d M Y H:i:s e', strtotime('created_at'));
        $feed['job']['referencenumber'] = 'shindeed'.$this->job->id;
        $feed['job']['requisitionid'] = $this->job->id;
        $feed['job']['url'] = \URL::To('jobs/'.$this->job->id);
        $feed['job']['company'] = $school->name;
        $feed['job']['sourcename'] = $school->name;
        $feed['job']['city'] = $school->city;
        $feed['job']['state'] = $school->state;
        $feed['job']['country'] = $school->country;
        $feed['job']['postalcode'] = $school->zipcode;
        $feed['job']['streetaddress'] = $school->address;
        $feed['job']['email'] = env('MAIL_ADMIN');
        $feed['job']['job_description'] = $this->job->description;
        $feed['job']['jobtype'] = $this->job->time_requirement;
        $feed['job']['expirationdate'] = date('D, d M Y H:i:s e', strtotime('expires_at'));
        
        return $feed;
    }
}