<?php

namespace App\Enums;

enum ApplicationStatuses: string
{
    case STATUS_DRAFT = 'Draft';
    case STATUS_SUBMITTED = 'Submitted';

    case STATUS_PENDING = 'Pending Interview';

    case STATUS_SHORTLISTED = 'Shortlisted';

    case STATUS_DECLINED = 'Declined';

    case STATUS_HIRED = 'Hired';

    // Used as a soft delete for applcations
    case STATUS_WITHDRAWN = 'Withdrawn';

}
