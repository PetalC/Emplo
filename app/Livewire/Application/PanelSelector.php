<?php

namespace App\Livewire\Application;

use App\Livewire\Forms\MultiSelect;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class PanelSelector extends MultiSelect
{

    const EVENT_PANEL_SELECT_CHANGED = 'panel-selector-changed';

    public Job $job;

    public array $panel_member_names = [];
    public array $panel_possibilities;
    public string $refreshKey;
    public bool $isDropdownOpen;

    public function mount() {

        $this->panel_member_names = [];

        $users = $this->job->panel_members ?? [];

        foreach ($users as $user) {
            $this->panel_member_names[$user->id] = $user->name;
        }

        $this->panel_possibilities = $this->job->school->users()->selectRaw(DB::raw('users.id, CONCAT(users.first_name, \' \', users.last_name) as full_name'))->pluck( 'full_name', 'id' )->toArray();

        $this->isDropdownOpen = false;

    }

//    #[On(MultiSelect::EVENT_SEARCH)]
//    public function getOptions($search_value) {
//        $results = User::query()->selectRaw(DB::raw('id, CONCAT(first_name, \' \', last_name) as full_name'))
//            ->where('email', 'like', '%'.$search_value.'%')
//            ->orWhere('first_name', 'like', '%'.$search_value.'%')
//            ->orWhere('last_name', 'like', '%'.$search_value.'%')
//            ->pluck('full_name', 'id')
//            ->toArray();
//        if ($results) {
//            $this->panel_possibilities = $results;
//        }
//        $this->isDropdownOpen = true;
//    }

    #[On(MultiSelect::EVENT_ADDED_OPTION)]
    public function addPanelMember($user_id) {
//        $userToAdd = $this->job->users->find($user_id);
//        $userToAdd = User::find($user_id);
//        if (!$userToAdd)
//            dd('no user with id ', $user_id);
        $this->job->panel_members()->attach($user_id);
        $this->dispatch(self::EVENT_PANEL_SELECT_CHANGED);
    }

    #[On(MultiSelect::EVENT_REMOVED_OPTION)]
    public function removePanelMember($user_id) {
        $this->job->panel_members()->detach([$user_id]);
        $this->dispatch(self::EVENT_PANEL_SELECT_CHANGED);
    }

    public function render() {

//        $this->refreshKey = json_encode([$this->panel_possibilities, $this->panel_member_names]);

        return view('livewire.application.panel-selector');

    }

}
