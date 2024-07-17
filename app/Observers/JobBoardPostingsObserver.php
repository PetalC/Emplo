<?php

namespace App\Observers;

use App\Models\JobBoardPostings;

class JobBoardPostingsObserver {

    /**
     * Handle the JobBoardPostings "created" event.
     */
    public function created(JobBoardPostings $jobBoardPostings): void {
        //
    }

    /**
     * Handle the JobBoardPostings "updated" event.
     */
    public function updated(JobBoardPostings $jobBoardPostings): void {
        //
    }

    /**
     * Handle the JobBoardPostings "deleted" event.
     */
    public function deleted(JobBoardPostings $jobBoardPostings): void {
        //
    }

    /**
     * Handle the JobBoardPostings "restored" event.
     */
    public function restored(JobBoardPostings $jobBoardPostings): void {
        //
    }

    /**
     * Handle the JobBoardPostings "force deleted" event.
     */
    public function forceDeleted(JobBoardPostings $jobBoardPostings): void {
        //
    }

}
