<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\JobBoardSettings;
use App\Models\School;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class JobBoardSettingsModal extends Component
{
    #[Modelable]
    public $open_modal = true;

    #[Locked]
    public School $school;

    public array $board_settings = [
            'seek' => ['account_number' => '', 'api_key' => ''],
            'LinkedIn' => ['account_number' => '', 'api_key' => ''],
            'indeed' => ['account_number' => '', 'api_key' => '']
        ];

    public function rules(){
        return [
            'board_settings' => 'array',
        ];
    }

    public function mount( School $school )
    {
        $this->school = $school;

        if ($this->school->jobBoardSettings) {
            $this->board_settings = $this->school->jobBoardSettings->board_settings;
        }

    }


    public function submitForm(){

        $this->validate();

        if (!$this->school->jobBoardSettings) {
            // Create a new JobBoardSettings if it doesn't exist
            $this->school->jobBoardSettings()->create([
                'school_id' => $this->school->id,
                'board_settings' => $this->board_settings
            ]);

            // Refresh the school model to load the new relationship
            $this->school->load('jobBoardSettings');
        } else {
            // Update existing JobBoardSettings
            $this->school->jobBoardSettings->board_settings = $this->board_settings;
            $this->school->jobBoardSettings->save();
        }

        session()->put('current_school', $this->school);

    }

    public function render()
    {

        if( $this->open_modal != 'job-boards' ) {
            return '<div></div>';
        }

        return view('livewire.school.settings.modals.job-board-settings-modal');
    }
}
