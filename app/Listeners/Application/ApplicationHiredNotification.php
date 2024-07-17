<?php

namespace App\Listeners\Application;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationHired;
use App\Events\Application\ApplicationStatusChanged;
use App\Mail\Application\External\ApplicantHiredEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ApplicationHiredNotification
{

    /**
     * Handle the event.
     */
    public function handle(ApplicationHired $event): void
    {
        $event->application->status = ApplicationStatuses::STATUS_HIRED;
        $event->application->hired_at = Carbon::now();
        $event->application->save();

        // TODO: update job to be closed
        // TODO: possibly alert all unsuccessful applicants
        ApplicationStatusChanged::dispatch($event->application);

        $email = trim($event->application->user->email);

        $subject = $event->application->job->school->name.': '.
            $event->application->job->title.' Successful';

        $message = 'You did it!';

        // TODO: at some point there might be onboarding docs etc to add to the hiring email
        $attachments = [];

        if (!empty($email)) {
            $hiredEmail = new ApplicantHiredEmail($subject, $message);
            foreach ($attachments as $attachment) {
                $hiredEmail->attach($attachment);
            }
            Mail::to($email)->send($hiredEmail);
        }

    }
}
