<?php

namespace App\Enums;

enum JobStatus: string {

//    case CREATED = 'Created';

    case DRAFT = 'Draft';

    case OPEN = 'Open';

    //POSTED is for jobs that have been created, but not posted to Employo These need to not display on searches etc, but still need to be manageable in the ATS etc.
    case POSTED = 'Posted';

//    case PENDING = 'Pending Decision';

    case CLOSED = 'Closed';

    case CANCELLED = 'Cancelled';

}
