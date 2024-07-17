<?php

namespace App\Enums;

/**
 * Empty search types to report on
 */
enum EmptySearchTypes: string
{
    case JOB_SEARCH = 'Job Search';
    case SCHOOL_SEARCH = 'School Search';
    case TAXONOMY_FILTER_SEARCH = 'Taxonomy Filter Search';

}
