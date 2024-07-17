<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\IndexController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\BillingPolicyController;
use App\Http\Controllers\CandidatePolicy;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\SchoolPolicy;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Dashboard\ApplicantsController;
use App\Http\Controllers\Dashboard\CampusController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\JobCenterController;
use App\Http\Controllers\Dashboard\ResourceController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\SchoolController;
use App\Http\Controllers\Dashboard\StaffroomController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComingSoonController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\UIController;
use App\Http\Middleware\EnsureApplicantUserHasProfile;
use App\Http\Middleware\EnsureCampusIsSetInSession;
use App\Http\Middleware\SetColorsIfCampusIsSet;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * UI
 */
//Route::get('/ui', UIController::class)->name('ui');
Route::get('/candidate_policy', CandidatePolicy::class)->name('candidate_policy');
Route::get('/school_policy', SchoolPolicy::class)->name('school_policy');
Route::get('/auth', \App\Livewire\Auth::class )->name('auth'); //@Nate @James we can change any of the single page livewire components like this.
                                                                                // It has some security advantages as well.
Route::get('/auth/verify_email', [ IndexController::class, 'verify_email' ] )->name('verification.notice');
Route::get('/auth/reset_password', [ IndexController::class, 'reset_password' ])->name('password.reset');

//https://laravel.com/docs/11.x/verification#the-email-verification-handler
Route::get('/email/verify/{id}/{hash}', function ( EmailVerificationRequest $request) {
    $request->fulfill();
    toast()->success('Email verified successfully')->pushOnNextPage();
    return redirect()->intended( '/auth' );
})->middleware([ 'signed'])->name('verification.verify');

Route::post('/logout', LogoutController::class)->name('logout');

Route::get('/', HomeController::class)->name('home');
Route::get('/search', [ SearchController::class, 'index' ] )->name('search');
Route::get('/candidates', \App\Livewire\Candidates::class )->name('candidates');
Route::get('/about', AboutController::class)->name('about');
Route::get('/contact', ContactController::class)->name('contact');
Route::get('/terms_conditions', [ TermsConditionsController::class, 'candidates' ] )->name('terms_policy');
Route::get('/employer_terms_conditions', [ TermsConditionsController::class, 'employer' ] )->name('employer_terms_policy');
Route::get('/billing_policy', BillingPolicyController::class)->name('billing_policy');
Route::get('/be_careful', SafetyController::class )->name('be_careful' );
//Route::get('/coming-soon', ComingSoonController::class)->name('coming-soon');


Route::get('/feeds/ehq', '\App\Http\Controllers\Feeds\ExternalFeedsController@educationHq')->name('feeds.ehq');
Route::get('/feeds/indeed', '\App\Http\Controllers\Feeds\ExternalFeedsController@indeed')->name('feeds.indeed');

Route::prefix( 'dashboard' )->middleware( ['auth', 'verified', 'can:school.view-dashboard' ] )->group( function () {

    Route::get('/schools', [ SchoolController::class, 'index' ] )->name('school.select_school')->middleware( 'can:school.view-dashboard' );
    Route::get('/campuses', [ CampusController::class, 'index' ] )->name('school.campuses' )->middleware( 'can:school.view-dashboard' );

    Route::middleware( [ EnsureCampusIsSetInSession::class, SetColorsIfCampusIsSet::class ] )->group( function(){

        Route::get('/', [ DashboardController::class, 'index' ] )->name('school.dashboard');
        Route::get('/resources', [ ResourceController::class, 'index'] )->name('school.resources');
        Route::get('/settings', [ SettingController::class, 'index'] )->name('school.settings');

        Route::get('/applicants', [ ApplicantsController::class, 'index'] )->name('school.applicants');
        Route::get('/applicants/{job}', [ ApplicantsController::class, 'view_applicants'] )->name('school.applicants.view');
        Route::get('/applicants/reference-check/{referenceCheck}', [ ReferenceController::class, 'view'] )->name('school.applicants.reference.check');
        Route::get('/application/{application}/nominate-references', [ ReferenceController::class, 'nominate'] )->name('school.applicants.references.nominate');

        Route::middleware(['can:school.manage-jobs'])->group(function () {
            Route::get( '/job-center', [ JobCenterController::class, 'index' ] )->name( 'school.jobcenter.index' );
            Route::get( '/job-center/closed', [ JobCenterController::class, 'closed' ] )->name( 'school.jobcenter.closed' );
            Route::get( '/job-center/draft', [ JobCenterController::class, 'draft' ] )->name( 'school.jobcenter.draft' );
            Route::get( '/job-center/create', [ JobCenterController::class, 'create' ] )->name( 'school.jobcenter.create' );
            Route::get( '/job-center/{job}', [ JobCenterController::class, 'edit' ] )->name( 'school.jobcenter.edit' );
        } );

        Route::middleware(['can:school.manage-campuses'])->group(function () {
//            Route::get('/campuses', [ CampusController::class, 'index' ] )->name('school.campuses' );
            Route::get('/campuses/profile', [ CampusController::class, 'view_profile' ] )->name('school.campus_profile' );
            Route::get('/campuses/create', [ CampusController::class, 'create' ] )->name('school.campuses.create' );
            //These routes will be needed again when and if we decide to implement multiple campus profiles
//            Route::get('/campuses/{campus}/edit', [ CampusController::class, 'edit' ] )->name('school.campus.edit' );
//            Route::get('/campuses/{campus}/profiles', [ CampusController::class, 'profiles' ] )->name('school.campus.profiles' );
//            Route::get('/campuses/{campus}/profile/create', [ CampusController::class, 'create_profile' ] )->name('school.campus.create_profile' );
//            Route::get('/campuses/{campus}/profile/{profile}', [ CampusController::class, 'view_profile' ] )->name('school.campus.view_profile' );
        });

        Route::prefix('staffroom')->middleware(['can:school.manage-staffroom'])->group(function () {
            Route::get('/candidates', [ StaffroomController::class, 'candidates_index' ])->name('school.staffroom.candidates');
            Route::post('/sendEmail', [ StaffroomController::class, 'send_email' ])->name('school.staffroom.sendEmail');
        });

    } );

});

Route::get('/job/{job}', [ JobController::class, 'view'])->name('job');
Route::get('/job/{job}/apply', [JobController::class, 'apply'])->name('job.apply');

Route::get('/schools', [ SchoolsController::class, 'index' ] )->name('schools');
Route::get('/schools/{campus}', [ SchoolsController::class, 'view' ])->name('schools.view');

Route::prefix( 'profile' )->middleware( [ 'auth', 'verified', 'can:jobseeker.all', EnsureApplicantUserHasProfile::class ] )->group( function () {
    Route::get('/', [ ProfileController::class, 'index' ] )->name('profile'); // User Only
    Route::get('/edit', [ ProfileController::class, 'edit' ] )->name('profile.edit');
    Route::get('/applications', [ ProfileController::class, 'applications' ] )->name('profile.applications');
    Route::get('/schools', [ ProfileController::class, 'schools' ] )->name('profile.schools' );
    Route::get('/jobs', [ ProfileController::class, 'jobs' ] )->name('profile.jobs' );
} );

Route::prefix( 'profile' )->middleware( [ 'auth', 'verified' ] )->group( function () {
    Route::get( '/view/{user}', [ ProfileController::class, 'view' ] )->name( 'profile.view' );
} );

if( env('APP_ENV' ) == 'local' ){
    Route::get( '/emailtemplate', function(){
        return (new \App\Mail\ComponentExampleMail())->render();
    } );
}

/* Linkedin */
Route::group(['prefix' => 'auth/linkedin', 'middleware' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\LinkedinController::class, 'redirectToProvider']);
    Route::get('/callback', [\App\Http\Controllers\LinkedinController::class, 'handleCallback']);
});
