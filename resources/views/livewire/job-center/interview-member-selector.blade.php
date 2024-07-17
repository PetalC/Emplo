<div class="flex gap-2 flex-wrap lg:justify-left justify-start">
    <div class="px-5 flex items-center cursor-pointer flex-grow" id="panel_member_input">
        <livewire:forms.multi-select
{{--            wire:model="panel_member_names"--}}
            badge_style="button"
            class="w-full"
            :selected="$selectedInterviewPanelMembers"
            :with-dropdown="false"
            :with-border="false"
            :with-selected-action="true"
        />
    </div>
</div>
