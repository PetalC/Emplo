<?php

namespace App\Livewire\Job;

use App\Enums\ApplicationStatuses;
use App\Models\Application;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
// use App\View\Components\AppLayout;
use App\Models\Job;
use Livewire\Attributes\Title;
use PHPUnit\Framework\Attributes\ExcludeGlobalVariableFromBackup;
//use RalphJSmit\Livewire\Urls\Facades\Url;
 use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Symfony\Component\Uid\Ulid;

class Apply extends Component {

    public Job $job;

    public Application|null $application = null;

    #[Url( as: 'application_id', keep: true )]
    public ?string $application_id;

    public User|null $user = null;

    /**
     * Controls whether stepper or completed component is shown
     *
     * @var bool
     */
    public bool $completed = false;

    #[Url( as: 'step', keep: true )]
    public string $current_component = 'criteria';

//    public int $current_step = 0;

    public array $steps = [
        'criteria',
        'documents',
        'reviews',
        'complete'
    ];

    public function mount() {

        /**
         * Some sanity tests.
         */
        if( isset( $this->application_id ) ) {
            $this->application = Application::where( 'ulid',$this->application_id )->first();

            if( ! $this->application || ( auth()->check() && $this->application->user()->isNot( auth()->user() ) ) ) {
                abort( 404 );
            }

            if( $this->application->job()->isNot( $this->job ) ) {
                abort( 418 );
            }
        }

        if( auth()->check() ) {

            $this->user = auth()->user();

            $this->application = Application::where( 'user_id', $this->user->id )->where( 'job_id', $this->job->id )->first();

            if( ! $this->application ) {
                $this->application = new Application( [
                    'ulid' => Ulid::generate( now() ),
                    'user_id' => $this->user->id,
                    'job_id' => $this->job->id,
                    'campus_id' => $this->job->campus_id,
                    'specialities' => $this->user->subjects()->pluck( 'name', 'subjects.id' )->toArray(),
                    'status' => ApplicationStatuses::STATUS_DRAFT,
                    'save_details' => true,
                ] );

                $this->application->save();

                /**
                 * Set the URL application_id ( Updates the URL with an application ID )
                 */
                $this->application_id = $this->application->ulid;

                /**
                 * We just created an application, we can't be anywhere else but the criteria step.
                 */
                $this->current_component = 'criteria';

            } else {

                /**
                 * If the application is not in draft, the user can only see the complete step.
                 */
                if( $this->application->status != ApplicationStatuses::STATUS_DRAFT ){
                    $this->setStep( 'complete' );
                } else {
                    //Not a draft application, but the user is trying to access the complete step.
                    if( $this->current_component === 'complete' ){
                        $this->current_component = 'criteria';
                    }
                }

                $this->application_id = $this->application->ulid;
                $this->render();
            }

        }

    }

    public function nextStep() {

        $step_count = count( $this->steps );

        if( $this->current_step() < $step_count - 1 ) {
            $this->setStep( $this->steps[ $this->current_step() + 1 ] );
        }

    }

    public function previousStep() {
        if( $this->current_step() > 0 ) {
            $this->setStep( $this->steps[ $this->current_step() - 1 ] );
        }
    }

    public function setStep( $step ) {

        /**
         * Handle the step validation logic here.
         *
         * The Application model has a validated_step attribute which is updated when the user has completed a step.
         * The steps in the "steps" param are in order of completion.
         */
        if( ! $this->application ){
            $this->current_component = 'criteria';
            return;
        }

        if( $this->canSeeStep( $step ) ){
            $this->current_component = $step;
        } else {
            toast()->info( 'Please complete the previous step first' )->push();
        }

    }

    public function canSeeStep( $step ) {

        if( $step === 'criteria'){
            return true;
        }

        if( ! $this->application ){
            return false;
        }

        /**
         * If the application is not in draft, the user can only see the complete step.
         */
        if( $this->application->status != ApplicationStatuses::STATUS_DRAFT ){
            if( $step === 'complete' ){
                return true;
            }
            return false;
        }

        /**
         * If the application is in draft, the user cannot see the complete step
         */
        if( $this->application->status == ApplicationStatuses::STATUS_DRAFT ){
            if( $step == 'complete' ){
                return false;
            }
        }

        /**
         * 'criteria',
         * 'documents',
         * 'reviews',
         * 'complete'
         *
         * At least one document is required and the user details have been filled in order to proceed to Review
         */
        if( $this->application->validated_step === 'criteria' && $step === 'documents') {
            return true;
        }

        if( $this->application->validated_step === 'documents' ){
            return true;
        }

        return false;

    }

    #[On('application_created')]
    public function applicationCreated( $application ){
        $this->application_id = $application['ulid'];
    }

//    #[On('user_created')]
//    public function userCreated( User $user ){
//
//        // If we have just created an application, we need to update the application_id which gives us the URL attribute
//        if( $user->wasRecentlyCreated && ! $this->user ){
//            $this->user = $user;
//        }
//
//        $this->render();
//
//    }

    #[On('refresh_application')]
    public function refresh_application(){
        $this->application = Application::where( 'ulid', $this->application_id )->first();
    }

    public function current_step(){
        return array_search( $this->current_component, $this->steps );
    }

//    public function updated( $property, $value ){
//        dd( $property, $value );
//
////        if( $application->wasRecentlyCreated && ! $this->application_id ){
////            $this->application_id = $this->application->ulid;
////        }
//
//    }

    public function render() {

        if( isset( $this->application ) ){

            if( $this->application->status != ApplicationStatuses::STATUS_DRAFT ){
                $this->setStep( 'complete' );
            }

        }

        return view('livewire.job.apply')->with([
            'current_component' => $this->current_component
        ]);
    }

//    #[On('job.{job.id}-application-stepper-complete')]
//    public function showCompletedScreen($job)
//    {
//        $this->completed = true;
//    }

}
