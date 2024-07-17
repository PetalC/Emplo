<?php

namespace App\Enums;

enum InterviewStatus: string
{
    case SCHEDULED = 'Scheduled';

    case PENDING_DECISION = 'Pending Decision';

    case APPROVED = 'Approved';

    case DECLINED = 'Declined';

}
