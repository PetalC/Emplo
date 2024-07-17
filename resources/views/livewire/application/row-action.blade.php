<div class="cursor-pointer w-full flex justify-end" x-data="{ openDeclineModal: false, openHireModal: false }">

    <x-select.dropdown icon="heroicon-o-ellipsis-horizontal" label="" class="rounded text-black p-2">
        <div class="flex" wire:click="shortlist">
            <x-icons.plus class="w-6 h-6 text-gray-500 pr-3" />
            <span class="text-center">Shortlist</span>
        </div>
        <div class="flex" wire:click="email">
            <x-icons.envelope class="w-6 h-6 text-gray-500 pr-3" />
            <span class="text-center">Email</span>
        </div>
        <div class="flex" @click="openDeclineModal = true">
            <x-icons.x-mark class="w-6 h-6 text-gray-500 pr-3" />
            <span class="text-center">Decline</span>
        </div>
        <div class="flex" @click="openHireModal = true">
            <x-icons.check-mark class="w-6 h-6 text-gray-500 pr-3" />
            <span class="text-center">Hire</span>
        </div>
    </x-select.dropdown>

    <x-modal x-show="openDeclineModal"
             x-on:click.outside="openDeclineModal = false"
             onClose="openDeclineModal = false"
             x-cloak>
        <x-confirm.alert :title="'Decline '.$application->user->name" action-text="Decline" x-on:submit="$wire.decline" onClose="onClose">
            <p>Declining this application will:</p>
            <ul>
                <li>Send an email to the candidate</li>
                <li>Candidate will need to re-apply to be considered again</li>
                <li>Each panel member will be notified</li>
            </ul>
        </x-confirm.alert>
    </x-modal>

    <x-modal x-show="openHireModal"
             x-on:click.outside="openHireModal = false"
             onClose="openHireModal = false"
             x-cloak>
        <x-confirm.alert title="Hiring approval" action-text="Approve" :can-submit="$canSubmit" x-on:submit="$wire.hire" onClose="onClose">
            <p>You are about to approve the hiring of {{ $application->user->first_name }} for the {{ $application->job->title }} role. Please confirm you have completed the following</p>
            <livewire:application.approval.checklist :application="$application" />
        </x-confirm.alert>
    </x-modal>
</div>
