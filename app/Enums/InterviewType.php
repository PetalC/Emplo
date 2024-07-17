<?php

namespace App\Enums;

enum InterviewType: string
{
    case FaceToFace = 'Face-to-Face';
    case Video = 'Video';
    case Phone = 'Phone';

    // Can define other interview types here
//    case OTHER = 'other';
}
