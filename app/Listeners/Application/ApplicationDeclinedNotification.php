<?php

namespace App\Listeners\Application;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationStatusChanged;
use App\Events\Application\ApplicationDeclined;
use App\Mail\Application\External\ApplicantDeclinedEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ApplicationDeclinedNotification
{

    /**
     * Handle the event.
     */
    public function handle(ApplicationDeclined $event): void
    {
        // @TODO Status updates should be moved to the event
        $event->application->status = ApplicationStatuses::STATUS_DECLINED;
        $event->application->declined_at = Carbon::now();
        $event->application->save();

        # Send internal email
//        ApplicationStatusChanged::dispatch($event->application);
    }
}
