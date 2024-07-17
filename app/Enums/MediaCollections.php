<?php

namespace App\Enums;

enum MediaCollections: string
{
    case APPLICATION_DOCUMENTS = 'Application Documents';

    case APPLICATION_SCHOOL_DOCUMENTS = 'Application School Documents';

    case CAMPUS_APPLICATION_DOCUMENTS = 'Campus Application Documents';

    case CAMPUS_LOGO = 'Campus Logo';

    case CAMPUS_BANNER = 'Campus Banner';

    case CAMPUS_GALLERY = 'Campus Gallery';

    case SCHOOL_RESOURCES = 'School Resources';

    case USER_RESOURCES = 'User Resources';

    case INTERVIEW_DOCUMENTS = 'Interview Documents';

    case JOBCENTRE_JOB_DOCUMENTS = 'Job Supporting Documents';

    case USER_PROFILE = 'User Profile';

}
