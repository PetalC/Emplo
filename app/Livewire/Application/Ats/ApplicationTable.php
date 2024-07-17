<?php

namespace App\Livewire\Application\Ats;

use App\Enums\ApplicationStatuses;
use App\Events\Application\ApplicationDeclined;
use App\Events\Application\ApplicationShortlisted;
use App\Livewire\Application\PanelSelector;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationTable extends Component
{

    #[Locked]
    public Job $job;

    public Collection $applications;

    public array $selected_applicants = [];

    public array $filters = [];

    private bool $should_select_all = false;
    private bool $should_deselect_all = false;

    protected $listeners = [
        'declineAll' => 'declineAllApplicants',
        PanelSelector::EVENT_PANEL_SELECT_CHANGED => 'refreshTable',
    ];

    public bool $bulkDisabled = false;

    public function selectAllApplicants(){
        $this->should_select_all = true;
    }

    public function deselectAllApplicants(){
        $this->should_deselect_all = true;
    }

    public function render() {

        $ids = $this->applications->pluck('id');

        if( $this->should_select_all ){
            $this->selected_applicants = array_fill_keys($ids->toArray(), true);
            $this->should_select_all = false;
        } elseif( $this->should_deselect_all ){
            $this->selected_applicants = array_fill_keys($ids->toArray(), false);
            $this->should_deselect_all = false;
        }

        /**
         * Prevent unnecessary and confusing re-rendering of the table
         *
         * x-model being bound live was creating an additional request as the selected_applicants array was being updated to add a new key of false.
         */
        foreach( $ids as $id ){
            if( ! array_key_exists($id, $this->selected_applicants) ){
                $this->selected_applicants[$id] = false;
            }
        }

        $this->bulkDisabled = empty($this->selected_applicants);

        $hired = false;//Application::where('status', ApplicationStatuses::STATUS_HIRED)->first();

        return view('livewire.application.ats.application-table')->with( [
            'hiredApplication' => $hired,
        ] );

    }

    public function shortlistAllApplicants() {

        foreach ($this->selected_applicants as $application_id => $selected) {
            if( $selected ){
                // Trigger decline events for each applicant
                ApplicationShortlisted::dispatch( Application::find( $application_id ) );
            }
        }

        // TODO: possibly fire additional event for bulk shortlisting (emailing digest email to panel members?)
        $this->deselectAllApplicants();

    }

    public function declineAllApplicants() {

        foreach ($this->selected_applicants as $application_id => $selected ) {

            if( $selected ){
                // Trigger decline events for each applicant
                ApplicationDeclined::dispatch( Application::find( $application_id ) );
            }

        }

        // TODO: possibly fire additional event for bulk declining (emailing digest email to panel members?)
        $this->deselectAllApplicants();

    }

}
