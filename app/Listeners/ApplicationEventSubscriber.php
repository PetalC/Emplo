<?php

namespace App\Listeners;

use App\Events\Application\ApplicationHired;
use App\Events\Application\ApplicationReapprove;
use App\Events\Application\ApplicationReconsider;
use App\Events\Application\ApplicationShortlisted;
use App\Events\Application\ApplicationUnlisted;
use App\Events\Application\ApplicationStatusChanged;
use App\Events\Application\ApplicationDeclined;
use App\Listeners\Application\ApplicationDeclinedNotification;
use App\Listeners\Application\ApplicationHiredNotification;
use App\Listeners\Application\ApplicationShortlistedNotification;
use App\Listeners\Application\ApplicationUnlistedNotification;
use App\Listeners\Application\Internal\AlertNotification;
use Illuminate\Events\Dispatcher;

class ApplicationEventSubscriber
{

    public function subscribe(Dispatcher $events): array
    {
        return [
            ApplicationDeclined::class => ApplicationDeclinedNotification::class,
            ApplicationShortlisted::class => ApplicationShortlistedNotification::class,
            ApplicationUnlisted::class => ApplicationUnlistedNotification::class,
            ApplicationReapprove::class => ApplicationUnlistedNotification::class,
            ApplicationReconsider::class => ApplicationUnlistedNotification::class,
            ApplicationHired::class => ApplicationHiredNotification::class,
            ApplicationStatusChanged::class => AlertNotification::class,
        ];
    }

}
