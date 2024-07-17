<?php

namespace App\Livewire\School\Settings\Modals;

use App\Models\School;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class EmployerLocationSettingsModal extends Component
{

    #[Modelable]
    public $open_modal = true;

    #[Locked]
    public School $school;

    public Collection $campuses;

    // Form data properties
    public string $newCampusName;
    public string $newCampusAddress;


    public function mount(School $school)
    {
        $this->school = $school;
        $this->campuses = $this->school->campuses()->with('primary_profile')->get();
    }

    public function rules(){
        return [
            'facebook' => 'string',
        ];
    }

    public function submitForm()
    {
        $this->validate();
    }

    public function addCampus()
    {
        $this->validate([
            'newCampusName' => 'required|string|max:255',
            'newCampusAddress' => 'required|string|max:255',
        ]);

        $campus = $this->school->campuses()->create([
            'url_slug' => 'campus-slug-' . time(),
            'is_active' => 1
        ]);

        $campus->profile()->create([
            'name' => $this->newCampusName,
            'address' => $this->newCampusAddress,
        ]);

        // Refresh the campuses list
        $this->campuses = $this->school->campuses()->with('primary_profile')->get();

        // Clear form inputs
        $this->newCampusName = '';
        $this->newCampusAddress = '';

        // Optional: add a flash message or notification
        session()->flash('message', 'Campus created successfully.');
    }

    public function render()
    {
        if ($this->open_modal != 'employer-locations') {
            return '<div></div>';
        }

        return view('livewire.school.settings.modals.employer-location-settings-modal');
    }

}
