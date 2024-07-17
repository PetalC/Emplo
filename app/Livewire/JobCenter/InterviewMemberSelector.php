<?php

namespace App\Livewire\JobCenter;

use App\Livewire\Forms\MultiSelect;
use App\Models\Interview;
use Livewire\Attributes\On;
use Livewire\Component;

class InterviewMemberSelector extends Component {

    public Interview $interview;
    /**
     * All panel member names keyed on id
     * @var array
     */
    public array $panelMemberNames = [];

    /**
     * Selected interview member names keyed on id
     * @var array
     */
    public array $selectedInterviewPanelMembers = [];

    public function mount() {
        $this->selectedInterviewPanelMembers = [];
        foreach ($this->interview->panel_members ?? [] as $panelMemberId) {
            $this->selectedInterviewPanelMembers[$panelMemberId] = $this->panelMemberNames[$panelMemberId];
        }
    }


    #[On(MultiSelect::EVENT_REMOVED_OPTION)]
    public function removeInterviewer($user_id) {
        $updatedMembers = [];
        foreach($this->interview->panel_members as $panel_member_id) {
            if ($panel_member_id == $user_id) {
                continue;
            }
            $updatedMembers[] = $panel_member_id;
        }
//        array_filter($this->interview->panel_members, function($el) with  { return $el !== $user_id });
        $this->interview->update(['panel_members' => $updatedMembers]);

//        $this->dispatch(self::EVENT_PANEL_SELECT_CHANGED);
    }


    public function render() {
        return view('livewire.job-center.interview-member-selector');
    }

}
