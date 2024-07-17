<?php

namespace App\Listeners\Application;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationShortlisted;
use App\Events\Application\ApplicationStatusChanged;
use Carbon\Carbon;

class ApplicationShortlistedNotification
{

    /**
     * Handle the event.
     */
    public function handle(ApplicationShortlisted $event): void
    {
        $event->application->status = ApplicationStatuses::STATUS_SHORTLISTED;
        $event->application->shortlisted_at = Carbon::now();
        $event->application->save();

        // TODO: fire declined email flow
        // TODO: fire shortlisted email flow
        // TODO: get list of people to notify when shortlisted

        ApplicationStatusChanged::dispatch($event->application);
    }
}
