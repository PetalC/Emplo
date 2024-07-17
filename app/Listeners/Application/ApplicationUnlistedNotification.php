<?php

namespace App\Listeners\Application;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationStatusChanged;
use App\Events\Application\ApplicationDeclined;
use App\Mail\Application\External\ApplicantDeclinedEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ApplicationUnlistedNotification
{

    /**
     * Handle the event.
     */
    public function handle($event): void {

        $event->application->status = ApplicationStatuses::STATUS_SUBMITTED;
        $event->application->declined_at = null;
        $event->application->save();

        # Send internal email
        ApplicationStatusChanged::dispatch($event->application);

    }
}
