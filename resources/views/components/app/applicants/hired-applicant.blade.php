@props( [
    // English issue: // difference between selected (currently checked box) and "selected" as in the applicant was chosen for the position i.e. hired
    'application'
])


<div
    x-data="{
        showEmailApplicantModal: false,
        showReconsiderConfirmation: false
    }"
    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-y-6">
    <div class="grid justify-center items-center justify-items-center grid-cols-subgrid col-span-1 md:col-span-2 xl:col-span-12 xl:row-span-2 border
            rounded-lg p-8 md:pl-8 md:pr-2 md:pb-8 border-2 border-green-600 bg-green-50">
        <div class="md:col-span-3 flex flex-col xl:flex-row xl:row-span-2 items-center justify-between text-center xl:border-r xl:border-r-gray-200">
            <div class="w-56 h-56 rounded-lg overflow-hidden md:p-4">
                <img src="{{ asset('assets/app/anne.png') }}" class="w-56 h-56" />
            </div>
            <div class="flex items-center gap-4">
                <div class="py-4 pr-4">
                    {{  $application->user->name }}
                    <x-icon name="heroicon-o-exclamation-circle" class="inline-block -translate-y-[1px] w-5 h-5"/>
                    <div class="text-gray-400 bg-white bg-opacity-50">5.2km Away</div>
                </div>

            </div>
        </div>

        <div class="md:col-span-2 p-4 mx-auto xl:mx-0">

            <div>
                <x-select.dropdown label="LE" class="rounded text-black p-2">
                    <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
                    <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
                    <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
                </x-select.dropdown>
                <x-select.dropdown label="TI" class="rounded text-blac p-2">
                    <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
                    <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
                    <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
                </x-select.dropdown>
                <x-select.dropdown label="SR" class="bg-success rounded text-white p-2">
                    <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
                    <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
                    <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
                </x-select.dropdown>
            </div>

        </div>

        <div class="md:col-span-2 mx-auto xl:mx-0 mb-4 xl:mb-0">
            <x-app.user.badges :user="$application->user" class="bg-opacity-50"/>
        </div>

        <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
            <livewire:application.registrations :application="$application"/>
        </div>

        <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
            <livewire:application.documents :application="$application"/>
        </div>


        <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
            <livewire:application.interview :application="$application"/>
        </div>

        <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
            <livewire:application.references :application="$application"/>
        </div>
        <div class="col-span-1 flex flex-col gap-3 xl:flex-row xl:col-span-9 xl:col-start-4 xl:row-start-2" >
            <x-button.outline @click="showEmailApplicantModal = true" class="w-full">
                <x-icons.envelope class="w-6 h-6 text-gray-500 pr-3"/>
                <h2 class="text-xs text-gray-500">Email Applicant</h2>
            </x-button.outline>
            <x-button.outline @click="showReconsiderConfirmation = true" class="w-full">
                <x-icons.speech class="w-6 h-6 text-gray-500 pr-3"/>
                <h2 class="text-xs text-gray-500">Reconsider</h2>
            </x-button.outline>
        </div>

    </div>

    <x-modal x-show="showEmailApplicantModal"
             x-on:click.outside="showEmailApplicantModal = false"
             onClose="showEmailApplicantModal = false"
             :application="$application">
        <livewire:application.ats.email-form :application="$application"/>
    </x-modal>

    <x-modal x-show="showReconsiderConfirmation"
             x-on:click.outside="showReconsiderConfirmation = false"
             onClose="showReconsiderConfirmation = false"
             :application="$application">
        <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3>Are you sure you want to reconsider {{ $application->user->name }}?</h3>
                <p>This will re-open the job and remove {{ $application->user->name }} as the hired candidate - ready to be assessed again</p>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button @click="$wire.dispatch('reconsider', { id: '{{ $application->id }}' }); showReconsiderConfirmation = false" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary disabled:bg-gray-50 disabled:text-black sm:ml-3 sm:w-auto"
                    >
                        Hire
                    </button>
                </div>
            </div>
        </div>
    </x-modal>

</div>
