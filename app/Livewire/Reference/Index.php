<?php

namespace App\Livewire\Reference;

use App\Models\Job;
use App\Models\User;
use Livewire\Component;
use App\Models\ReferenceCheck;

class Index extends Component
{
    public ReferenceCheck $reference_check;
    public Job $job;
    public User $candidate;
    public array $details = [];

    public function mount(ReferenceCheck $referenceCheck)
    {
        $this->reference_check = $referenceCheck;
        $this->job = $this->reference_check->application->job;
        $this->candidate = $this->reference_check->application->user;

        $referee_details = [
            'full_name' => $this->reference_check->referee->name,
            'position' => $this->reference_check->position,
            'place_emp' => $this->reference_check->place_of_emplo,
            'work_with_date_start' => $this->reference_check->work_with_date_start,
            'work_with_date_end' => $this->reference_check->work_with_date_end,
            'preferred_contact' => $this->reference_check->referee->email,
        ];

        $reference_check_details = [
            'child_protection' => ($this->reference_check->child_protection_details == null),
            'child_protection_details' => $this->reference_check->child_protection_details,
            'performance_related' => ($this->reference_check->performance_related_details == null),
            'performance_related_details' => $this->reference_check->performance_related_details,
            'reason_not_with_children' => ($this->reference_check->reason_not_with_children_details == null),
            'reason_not_with_children_details' => $this->reference_check->reason_not_with_children_details,
            'recent_child_protection' => $this->reference_check->recent_child_protection,
            'recommended_yes_details' => $this->reference_check->recommended ? $this->reference_check->recommended_reason : null,
            'recommended_no_details' => !$this->reference_check->recommended ? $this->reference_check->recommended_reason : null,
            'rehire_yes_details' => $this->reference_check->rehire ? $this->reference_check->rehire_reason : null,
            'rehire_no_details' => !$this->reference_check->rehire ? $this->reference_check->rehire_reason : null,
        ];

        // TODO: will probably want to make this dynamic at some point
        $reference_check_ratings = [
            'know_student' => $this->reference_check->know_student,
            'know_content' => $this->reference_check->know_content,
            'plan_for_teaching' => $this->reference_check->plan_for_teaching,
            'create_learning' => $this->reference_check->create_learning,
            'assess_learning' => $this->reference_check->assess_learning,
            'professionalism' => $this->reference_check->professionalism,
            'colleague_engagement' => $this->reference_check->colleague_engagement,
        ];

        $this->details = array_merge($referee_details, $reference_check_details, $reference_check_ratings);
    }

    protected $referee_rules = [
        'details.full_name' => 'required|string',
        'details.position' => 'required|string',
        'details.place_emp' => 'required|string',
        'details.preferred_contact' => 'required|string',
    ];

    protected $messages = [
        'details.full_name.required' => 'Full name is required',
        'details.preferred_contact.required' => 'Preferred contact details is required',
        'details.position.required' => 'Position and subject is required',
        'details.place_emp.required' => 'Place of employment is required',
    ];

    public function submit()
    {
        $this->validate( $this->referee_rules );
        $this->reference_check->update([
            'status' => 'Completed'
        ]);
        toast('Submitted request form');
        return redirect('auth');
    }

    public function render()
    {
        return view('livewire.reference.index');
    }
}
