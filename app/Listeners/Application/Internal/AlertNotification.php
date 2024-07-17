<?php

namespace App\Listeners\Application\Internal;

use App\Events\Application\ApplicationStatusChanged;
use App\Mail\Application\Internal\ApplicantAlert;
use Illuminate\Support\Facades\Mail;

class AlertNotification
{

    /**
     * Handle the event.
     */
    public function handle(ApplicationStatusChanged $event): void
    {
        // TODO: determine emails to send internal notification to
        $email = trim('testadmin@school.com');
        $subject = $event->application->job->title.' '.$event->application->status->value.' - '.$event->application->user->name;
        $message = $event->application->status->value;
        if (!empty($email)) {
            Mail::to($email)->send(new ApplicantAlert($subject, $message, $event->application));
        }

    }
}
