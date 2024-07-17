<?php

namespace App\Enums;

enum PlanFeatures: string {

    case DASHBOARD = 'Dashboard';

    case COMPLIMENTARY_SETUP = 'Complimentary Setup';

    case EMPLOYER_PROFILE = 'Employer Profile';

    case SINGLE_USER = 'Single User';

    case MULTI_USER = 'Multi-User';

    case JOB_CENTER = 'Job Center';

    case RESOURCE_LIBRARY = 'Resource Library';

    case STAFF_ROOM = 'Staff Room';

    case ATS = 'ATS';

    case PAID_SOCIAL_BOOSTERS = 'Paid Social Boosters';

    case ADVERTISING_CREDITS = 'Advertising Credits';

    case AI_FAQ_BOT = 'AI FAQ Bot';

    case ID_VERIFICATIONS = 'ID Verifications';

    case CRIMINAL_CLEARANCE_CHECKS = 'Criminal Clearance Checks';

}
