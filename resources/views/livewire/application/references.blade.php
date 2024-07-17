@php use App\Enums\SystemEmailTypes; @endphp
<div x-data="{ showEmailApplicantModal : false, openReferencesModal : false }"
     class="flex items-center gap-2 justify-center">
    @if($application->reference_checks->isEmpty())
        @if (!$application->references_requested_at)
            <div @click="showEmailApplicantModal = true"
                 class="items-center flex flex-row gap-1">
                <x-icons.star/>
                Request
            </div>
        @else
            <div class="items-center flex flex-row gap-1">
                <x-icon name="heroicon-o-clock" class="w-6 h-6" />
                Requested {{ $application->references_requested_at->diffForHumans() }}
            </div>
        @endif
    @else
        <div @click="openReferencesModal = true"
             class="bg-gray-200 p-1 rounded flex flex-row items-center gap-1 text-gray-800 cursor-pointer">
            <x-icon name="heroicon-o-pencil" class="w-4 h-4"/>
            <a class="underline">{{count($completedReferenceChecks)}} / {{ count($application->reference_checks) }}</a>
        </div>
    @endif
    <x-modal x-show="showEmailApplicantModal"
             x-on:click.outside="showEmailApplicantModal = false"
             onClose="showEmailApplicantModal = false"
             :application="$application">
        <livewire:application.ats.email-form :application="$application"
                                             email_type="{{ SystemEmailTypes::REQUEST_REFERENCES->value }}"/>
    </x-modal>
    <x-modal
        x-show="openReferencesModal"
        x-on:click.outside="openReferencesModal = false"
        onClose="openReferencesModal = false"
        x-cloak
        :withClose="false"
    >
        <div class="flex flex-col gap-6 items-center">
            <h5 class="text-2xl">Reference Checks</h5>
            @foreach($application->reference_checks as $reference_check)
                <x-app.applicants.reference-check :reference-check="$reference_check"/>
            @endforeach

            <x-buttons.primary class="mt-6" @click="openReferencesModal = false" size="xl">Done</x-buttons.primary>
        </div>
    </x-modal>
</div>
