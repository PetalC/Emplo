<?php

namespace App\Livewire\Application;

use App\Enums\ApplicationStatuses;
use App\Models\Application;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RowAction extends Component
{

    #[Locked]
    public bool $showDeclineAlert;
    #[Locked]
    public bool $showHireConfirmation;
    public bool $canSubmit;
    public bool $checkListCompleted;

    #[Locked]
    public Application $application;

    public function mount(Application $application)
    {
        $this->showDeclineAlert = false;
        $this->showHireConfirmation = false;
        $this->canSubmit = false;
        $this->checkListCompleted = false;
        $this->application = $application;
    }

    public function shortlist()
    {
        $this->application->update(['status' => ApplicationStatuses::STATUS_SHORTLISTED]);
    }

    public function decline()
    {
        $this->showDeclineAlert = true;
        $this->application->update(['status' => ApplicationStatuses::STATUS_DECLINED]);
    }

    public function hire()
    {
        $this->application->update(['status' => ApplicationStatuses::STATUS_HIRED]);
        $this->showHireConfirmation = true;
    }

    public function render()
    {
        return view('livewire.application.row-action');
    }
}
