<?php

namespace App\Observers;

use App\Enums\LicencingAuthorityTypes;
use App\Mail\CheckTeacherRegistration;
use App\Models\Certification;
use App\Services\NESARegistration;
use App\Services\NTTRBRegistration;
use App\Services\QCTRegistration;
use App\Services\TRBSARegistration;
use App\Services\TRBTASRegistration;
use App\Services\TRBWARegistration;
use App\Services\VITRegistration;
use Illuminate\Support\Facades\Mail;

class CertificationsObserver {

    /**
     * Handle the Certification "created" event.
     */
    public function created(Certification $certification): void {

        //@TODO Put these on a queued job if they take a long time to process
        //@TODO Refine the logic around when a lookup runs.
//        switch( $certification->certification ){
//            case 'QCT':
//                $certification->is_valid = QCTRegistration::search( $certification );
//                $certification->saveQuietly();
//                break;
//        }

    }

    /**
     * Handle the Certification "updated" event.
     */
    public function updated(Certification $certification): void {

        switch( $certification->certification ){
            case LicencingAuthorityTypes::QCT:
                $certification->is_valid = QCTRegistration::search( $certification->certification_id );
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::NTTRB:
                $certification->is_valid = NTTRBRegistration::search( $certification->certification_id );
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::TRBSA:
                $certification->is_valid = TRBSARegistration::search( $certification->certification_id, $certification->user->first_name, $certification->user->last_name);
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::TRBT:
                $certification->is_valid = TRBTASRegistration::search( $certification->certification_id, $certification->user->first_name, $certification->user->last_name);
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::VIT:
                $certification->is_valid = VITRegistration::search( $certification->certification_id, $certification->user->first_name, $certification->user->last_name);
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::NESA:
                $certification->is_valid = NESARegistration::search( $certification->certification_id, $certification->user->first_name, $certification->user->last_name);
                $certification->saveQuietly();
                break;
            case LicencingAuthorityTypes::TRBWA:

                $subject = 'Teacher Registration Review';

                $message = 'Please manually check the TRBWA Registration for '. $certification->user->first_name . ' ' .$certification->user->last_name . ' with registration number ' . $certification->certification_id;

                Mail::to(env( 'CONTACT_EMAIL', 'ben.casey@humanpixel.com.au' ))->send(new CheckTeacherRegistration($subject, $message));

                // TRBWA have secure forms we can't just query (boo)
                //$certification->is_valid = TRBWARegistration::search( $certification->certification_id, $certification->user->first_name, $certification->user->last_name);
               // $certification->saveQuietly();
                break;

        }

    }

    /**
     * Handle the Certification "deleted" event.
     */
    public function deleted(Certification $certification): void
    {}

    /**
     * Handle the Certification "restored" event.
     */
    public function restored(Certification $certification): void
    {}

    /**
     * Handle the Certification "force deleted" event.
     */
    public function forceDeleted(Certification $certification): void
    {}
}
