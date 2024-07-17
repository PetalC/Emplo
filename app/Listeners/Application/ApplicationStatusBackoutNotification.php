<?php

namespace App\Listeners\Application;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationReapprove;
use App\Events\Application\ApplicationReconsider;
use App\Events\Application\ApplicationStatusChanged;
use App\Events\Application\ApplicationUnlisted;

/**
 * Used for backing out an application's status - will lose shortlisted, hired and declined dates
 */
class ApplicationStatusBackoutNotification
{

    /**
     * Handle the event.
     */
    public function handle(ApplicationUnlisted|ApplicationReapprove|ApplicationReconsider $event): void
    {
        $event->application->status = ApplicationStatuses::STATUS_SUBMITTED;
        $event->application->shortlisted_at = null;
        $event->application->declined_at = null;
        $event->application->hired_at = null;
        $event->application->save();

        // TODO: fire declined email flow
        // TODO: fire shortlisted email flow
        // TODO: get list of people to notify when shortlisted

        ApplicationStatusChanged::dispatch($event->application);
    }
}
