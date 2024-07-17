<?php

namespace App\Enums;

enum LicencingAuthorityTypes: string {

    case NONE = '';
    case QCT = 'QCT';
    case NESA = 'NESA';
    case NTTRB = 'NTTRB';
    case TRBSA = 'TRBSA';
    case TRBT = 'TRBT';
    case TRBWA = 'TRBWA';
    case VIT = 'VIT';
    case OTHER = 'Other';

//    case BLUECARD_QLD = 'Blue Card – Queensland';

    //case QLD_COLLEGE_OF_TEACHERS = 'Queensland College of Teachers'; //This is the same as QCT

    //Blue Card – Queensland

}
