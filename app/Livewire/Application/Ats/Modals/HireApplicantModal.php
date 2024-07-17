<?php

namespace App\Livewire\Application\Ats\Modals;

use App\Enums\ApplicationStatuses;
use App\Livewire\Application\Ats\ApplicationTable;
use App\Livewire\School\Ats;
use App\Models\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Component;

class HireApplicantModal extends Component {

    #[Modelable]
    public $open_modal = true;

    #[Reactive]
    public mixed $params = null;

    public bool $is_complete = false;

    #[Validate( 'required|accepted' )]
    public bool $reference_check = false;

    #[Validate( 'required|accepted' )]
    public bool $licencing_check = false;

    #[Validate( 'required|accepted' )]
    public bool $working_with_children_check = false;

    #[Validate( 'required|accepted' )]
    public bool $application_check = false;

    public function submitForm(){

        $this->validate();

        $applications = Application::whereIn('id', $this->params ?? [] )->get();

        foreach( $applications as $application ) {
            $application->status = ApplicationStatuses::STATUS_HIRED->value;
            $application->save();
        }

        //@TODO - Send email to applicant, and one to each panel member

        $this->is_complete = true;
    }

    public function clearFields(){
        $this->reference_check = false;
        $this->licencing_check = false;
        $this->working_with_children_check = false;
        $this->application_check = false;
        $this->is_complete = false;

        $this->dispatch( 'update_ats_table' )->to( Ats::class );
    }

    public function updated( $field, $value ) {
        $this->validateOnly( $field );
    }

    public function render() {

        if( $this->open_modal != 'hire-applicant' ) {
            return '<div></div>';
        }

        $applications = Application::whereIn('id', $this->params ?? [] )->get();

        return view('livewire.application.ats.modals.hire-applicant-modal' )->with([
            'applications' => $applications,
        ]);

    }

}
