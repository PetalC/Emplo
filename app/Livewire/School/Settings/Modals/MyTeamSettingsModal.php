<?php

namespace App\Livewire\School\Settings\Modals;

use App\Enums\RoleNames;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class MyTeamSettingsModal extends Component
{

    #[Modelable]
    public $open_modal = true;
    #[Locked]
    public School $school;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password = '';
    public string|null $newUserRole;
    public array $roles;
    public int|null $editUserId = null;

    private $excludedRoleNames = [];

    public function boot() {
        $this->excludedRoleNames = [
            RoleNames::Developer->value,       // nova
            RoleNames::SuperAdmin->value,      // nova
            RoleNames::TaxonomyManager->value, // nova
            RoleNames::JobSeeker->value,
        ];
    }
    public function mount(School $school)
    {
        $this->school = $school;
        $this->roles = Role::whereNotIn('name',$this->excludedRoleNames)->pluck( 'name', 'id' )->toArray();
    }


    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->editUserId),
            ],
            'password' => $this->editUserId ? 'nullable|string|min:8' : 'required|string|min:8',
            'newUserRole' => 'required|string',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        $this->validate();

        $user = $this->editUserId ? User::findOrFail($this->editUserId) : new User();

        // Create or update the user and associate with the school
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        if (Str::length($this->password) > 0) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        if (!$this->editUserId) {
            $this->school->users()->save($user);
        }

        // Assign role
        if (!empty($this->newUserRole)) {
            $role = Role::findOrFail($this->newUserRole);
            $user->syncRoles([$role->name]); // SyncRoles expects an array of role names
        }

        // Reset the form inputs
        $this->resetForm();

        // Optional: Add a flash message
        session()->flash('message', $this->editUserId ? 'User updated successfully.' : 'User created successfully.');

        // Close the modal
        $this->open_modal = false;
    }

    public function resetForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->password = '';
        $this->newUserRole = '';
        $this->editUserId = null;
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->editUserId = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->newUserRole = $user->roles->pluck('name')->first();
    }

    public function removeFromSchool($userId)
    {
        $user = User::findOrFail($userId);

        // Remove the user from the school's users
        $this->school->users()->detach($user);

        // Refresh the user list
        $this->users = $this->school->users;
    }

    public function getAllowedRoles($user) {
        $allRoleNames = $user->getRoleNames()->toArray();
        $allowedNames = [];
        foreach ($allRoleNames as $roleName) {
            if (in_array($roleName, $this->excludedRoleNames)) {
                continue;
            }
            $allowedNames[] = $roleName;
        }
        return $allowedNames;
    }
    public function render()
    {
        if ($this->open_modal != 'my-team') {
            return '<div></div>';
        }

        // Exclude jobseekers
        $users = $this->school->users()
            ->whereDoesntHave('roles', function($query) {
                $query->where('name', RoleNames::JobSeeker->value);
            })->get();

        return view('livewire.school.settings.modals.my-team-settings-modal', [
            'users' => $users,
        ]);
    }
}
