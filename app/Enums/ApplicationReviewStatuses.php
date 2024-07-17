<?php

namespace App\Enums;

// @TODO There is a naming conflict here, we should seperate the 2 types here.
enum ApplicationReviewStatuses: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case DECLINED = 'declined';


    case RESUME = 'resume';
    // No way to tell system file uploaded is a cover letter or school application yet
    case COVER_LETTER = 'coverLetter';
    case SCHOOL_APPLICATION_FORM = 'schoolApplicationForm';
    case REFERREES = 'referees';

}
