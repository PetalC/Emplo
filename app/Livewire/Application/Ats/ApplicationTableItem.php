<?php

namespace App\Livewire\Application\Ats;

use App\Enums\ApplicationStatuses;
use App\Enums\SystemEmailTypes;
use App\Events\Application\ApplicationHired;
use App\Events\Application\ApplicationReapprove;
use App\Events\Application\ApplicationReconsider;
use App\Events\Application\ApplicationShortlisted;
use App\Events\Application\ApplicationDeclined;
use App\Events\Application\ApplicationUnlisted;
use App\Models\Application;
use App\Models\CampusProfile;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ApplicationTableItem extends Component
{

    #[Locked]
    public Application|null $application = null;

    #[Modelable]
    public bool|null $selected = false;

    public bool $canSubmitHire = false;
    public bool $checkListCompleted = false;
    public bool $hasHiredApplicant;

    public array|bool|null $user_flagged = false;

    public int|null $applicant_distance;

    public function mount(){
        $this->canSubmitHire = false;
        $this->checkListCompleted = false;

        if ($this->application->job && $this->application->user) {
            $this->user_flagged = $this->application->job->school
            ->flagged_users()
            ->where( 'user_id', $this->application->user->id )
            ->withPivot('flagged_by', 'flagged_at')
            ->first()?->toArray() ?? false;
        } else {
            $this->user_flagged = false;
        }

        if ($this->application->user && $this->application->user->profile && !is_null($this->application->user->profile->location)) {
            $placeWithDistance = CampusProfile::query()
                ->where('id', $this->application->campus->primary_profile->id)
                ->withDistance('location', $this->application->user->profile->location)
                ->first();

            $this->applicant_distance = round($placeWithDistance->distance, 2);
        }
    }

    public function shortlistApplicant() {
        ApplicationShortlisted::dispatch($this->application);
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    // Backout status methods
    public function unlistApplicant() {
        ApplicationUnlisted::dispatch($this->application);
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    public function reapproveApplicant() {
        ApplicationReapprove::dispatch( $this->application );
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    public function reconsiderApplicant() {
        ApplicationReconsider::dispatch( $this->application );
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    public function declineApplicant() {
        ApplicationDeclined::dispatch( $this->application );
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    /**
     * Need to hire the applicant from a dispatched event from alpine
     * Each item hires the same event, so the id is passed in to hire just the specific application.
     * Can't use $this->application in this situation
     *
     * @param $id
     * @return void
     */
    #[On('hire')]
    public function hireApplicant($id) {
        //$this->authorize( 'hire', $this->application  );
        if ($this->application->id != $id) {
            return;
        }
        ApplicationHired::dispatch(Application::find($id));
        sleep(1);
        $this->dispatch( 'update_ats_table' );
    }

    #[On('can-submit-hire')]
    public function allowSubmitHire($id) {
        //$this->authorize( 'submit_hire', $this->application  );
        if ($this->application->id != $id) {
            return;
        }
        $this->canSubmitHire = true;
    }

    #[On(EmailForm::EVENT_SUBMITTED)]
    public function updateEmailSent($type, $application_id) {
        if ($this->application->id != $application_id) {
            return;
        }
        if ($type == SystemEmailTypes::REQUEST_REFERENCES->value) {
            $this->application->update([
                'references_requested_at' => Carbon::now()
            ]);
        }
    }

    public function render() {
        return view('livewire.application.ats.application-table-item');
    }
}
