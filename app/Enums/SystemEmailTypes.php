<?php

namespace App\Enums;

/**
 * Email types the system supports
 */
enum SystemEmailTypes: string
{
    case GENERIC = 'generic';
    case REQUEST_REFERENCES = 'request-references';

    // other types to handle here

}
