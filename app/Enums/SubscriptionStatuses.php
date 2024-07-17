<?php

namespace App\Enums;

enum SubscriptionStatuses: string
{

    case ACTIVE = 'Active';

    case CANCELLED = 'Cancelled';

    case PENDING = 'Pending';

}
