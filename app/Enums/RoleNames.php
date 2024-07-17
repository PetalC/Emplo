<?php

namespace App\Enums;

enum RoleNames: string
{
    case SchoolAdmin = 'School Admin';
    case SchoolAccountManager = 'School Account Manager';
    case SchoolSupport = 'School Support';
    case SuperAdmin = 'Super Admin';
    case Developer = 'Developer';
    case TaxonomyManager = 'Taxonomy Manager';
    case JobSeeker = 'Job Seeker';

    // TODO add in additional roles here

}
