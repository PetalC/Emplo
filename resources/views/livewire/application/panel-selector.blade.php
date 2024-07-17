@props([
    'job',
    'hideLeft' => false
])
<div class="border border-gray-200 rounded-lg flex mx-20 mt-12" x-data="{}">
    @if(!$hideLeft)
        <div class="flex gap-2 p-4 items-center border-r border-r-gray-200 cursor-pointer">
            <x-icon name="heroicon-o-plus" class="w-7 h-7 text-white bg-school_primary rounded p-1"/>
            <span class="text-sm text-gray-800 px-2 whitespace-nowrap">Add Panel Member</span>
        </div>
    @endif
    <div class="px-5 flex items-center cursor-pointer flex-grow" id="panel_member_input">
        <livewire:forms.multi-select
            wire:model="panel_member_names"
            badge_style="button"
{{--            :key="$refreshKey" class="w-full"--}}
            :selected="$panel_member_names"
            :options="$panel_possibilities"
            :with-border="false"
            :with-selected-action="true"
            :with-search="false"
            :show-dropdown="$isDropdownOpen"
        />
    </div>
</div>
