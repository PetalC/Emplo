<?php

namespace App\Observers;

use App\Models\Job;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Enums\JobBoardTypes;
use App\Notifications\JobCreatedNotification;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     */
    public function created(Job $job): void {

        if( ! $job->uuid ){
            $job->uuid = Str::uuid();
            $job->saveQuietly();
        }

    }

    /**
     * Handle the Job "updated" event.
     */
    public function updated(Job $job): void {
        $previous = $job->getOriginal();

        /* Execute only of Job goes from Draft to Publish */
        if (isset($previous['status']) && $previous['status']->value == 'Draft' && $job->status->value == 'Open') {

            /* Send a notification email to Employo Support */
            Notification::route('mail', 'sh.admin@the-schoolhouse.com.au')
                ->notify(new JobCreatedNotification($job));

            foreach ($job->postings as $jobBoard) {

                switch($jobBoard->job_board->value) {
                    case JobBoardTypes::COMPLETE_TEACHER_ON_NET->value:
                        $job->createTonJob();
                        break;

                    case JobBoardTypes::COMPLETE_SEEK->value:
                        $job->createSeekJob();
                        break;

                    case JobBoardTypes::SOCIAL_LINKEDIN->value:

                        if (!Auth::check()) {
                            break;
                        }

                        if (!Auth::user()) {
                            break;
                        }

                        $content = 'We have a new open position for '.$job->title;
                        $content .= ' more details at '.\URL::To('job/'.$job->uuid);

                        Auth::user()->createLinkedInPost($content);
                        break;
                }
            }


        }

        if( ! $job->uuid ){
            $job->uuid = Str::uuid();
            $job->saveQuietly();
        }

        // Clear the cache for the candidate statistics
//        Cache::forget( 'candidate_statistics_' . $job->id );

        // Update the URL slug, ensuring we have something to insert if the slug already exists
//        $slug = Str::slug( $job->title );
//
//        $exists = Job::where('url_slug', $slug)->where('id', '!=', $job->id)->exists();
//
//        if( $exists ){
//            $iterations = 1;
//            while( $exists ){
//                $slug = $slug . '-' . $iterations;
//                $iterations++;
//                $exists = Job::where('url_slug', $slug)->where('id', '!=', $job->id)->exists();
//            }
//        }
//
//        $job->url_slug = $slug;
//        $job->saveQuietly();

    }

    /**
     * Handle the Job "deleted" event.
     */
    public function deleted(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "restored" event.
     */
    public function restored(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     */
    public function forceDeleted(Job $job): void
    {
        //
    }
}
