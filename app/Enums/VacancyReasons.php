<?php

namespace App\Enums;

enum VacancyReasons: string
{

    case INTERNAL_PROMOTION = 'Internal Promotion';

    case ENROLMENT_INCREASE = 'Enrolment Increase';

    case RETIREMENT = 'Retirement';

    case RELOCATION = 'Relocation';

    case TERMINATION = 'Termination';

    case EXTERNAL_PROMOTION = 'External Promotion';

    case MATERNITY = 'Maternity';

    case RESIGNATION_CHANGED_SCHOOLS = 'Resignation - Changed Schools';

    case RESIGNATION_CHANGED_INDUSTRIES = 'Resignation - Changed Industries';

    case OTHER = 'Other';

    case NONE = ''; //Added to stop server error. This should be removed once the database is updated.

}
