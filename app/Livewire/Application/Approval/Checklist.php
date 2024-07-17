<?php

namespace App\Livewire\Application\Approval;

use App\Livewire\Application\Ats\ApplicationTableItem;
use App\Models\Application;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Checklist extends Component
{
    #[Locked]
    public Application $application;

    #[Locked]
    public bool $canSubmit;

    public array $checkboxes = [];

    public function mount(Application $application, bool $canSubmit)
    {
        $this->application = $application;
        $this->canSubmit = $canSubmit;
        $this->checkboxes = [
            'reference_checks' => false,
            'licensing' => false,
            'working_children' => false,
            'application_form' => false
        ];
    }

    public function updatedCheckboxes($value) {
        $count = 0;
        foreach ($this->checkboxes as $checkbox) {
            if ($checkbox)
                $count++;
        }
        $this->canSubmit = $count == count($this->checkboxes);
        if ($this->canSubmit) {
            $this->dispatch('can-submit-hire', $this->application->id)->to(ApplicationTableItem::class);
        }
    }

    public function render()
    {
        return view('livewire.application.approval.checklist');
    }
}
