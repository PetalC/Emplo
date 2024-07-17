<div x-data="{
    showDeclineAllConfirmation: false,
    showBulkEmailModal: false,
    showPanelEmailModal: false,
 }">

    <livewire:application.panel-selector :job="$job"/>

    @if( ! $applications->isEmpty() )
        <x-app.applicants.actions
            :job
            :selected_applicants="$selected_applicants"
            :bulkDisabled="$bulkDisabled"
            :disabledHire="count($selected_applicants) != 1 || $hiredApplication != null"
        />
    @endif

{{--    @if($hiredApplication)--}}
{{--        <div class="mt-12 mb-20 px-20 text-gray-700">--}}
{{--            <h3 class="text-center text-2xl p-5">Hired Candidate</h3>--}}
{{--            <x-app.applicants.hired-applicant :application="$hiredApplication"/>--}}
{{--        </div>--}}
{{--    @endif--}}

    @if( ! $applications->isEmpty() )

        <div class="mb-12 mt-6 px-20 text-gray-700">

            <h3 class="text-center text-2xl p-5 mb-6">All Applications</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-y-6" wire:loading.class="opacity-60 cursor-not-allowed">

                <div
                    class="hidden xl:grid col-span-1 xl:col-span-12 items-baseline text-center justify-items-center grid-cols-subgrid text-xs pt-4">

                    <div class="col-span-3">
                        Name
                    </div>

                    <div class="col-span-2">
                        Panel Review
                    </div>

                    <div class="col-span-2">
                        Safe Guarding Indicators
                    </div>

                    <div class="col-span-1">
                        Registration
                    </div>

                    <div class="col-span-1">
                        Documents
                    </div>

                    <div class="col-span-1">
                        Interview Details
                    </div>

                    <div class="col-span-1">
                        Reference Checks
                    </div>

                    <div class="col-span-1 text-right">
                        Actions
                    </div>

                </div>
                @foreach($applications as $application)
                    <livewire:application.ats.application-table-item
                        wire:key="application-{{ $application->id }}"
                        wire:model.live="selected_applicants.{{ $application->id }}"
                        :application="$application"
                        :has-hired-applicant="$hiredApplication !== null"
                    />
                @endforeach

            </div>

        </div>

    @else

        <div class="mt-12 mb-20 px-20 text-gray-700">
            <h2 class="text-center">There are no applicants yet. Feel free to prepare your panel for when the applications start rolling in!</h2>
        </div>

    @endif

    {{--Administrative chat--}}
    <div class="text-app justify-center flex flex-col gap-20 opacity-40 cursor-not-allowed my-20">
        <div class="flex justify-center">
            <x-icons.speech />
            <span class="ml-2">Applicant Tracking Chat</span>
        </div>
        <div class="lg:border rounded-lg border-gray-500 lg:px-10 lg:py-5">
            <div class="lg:h-64 py-5 flex flex-col gap-5">
                <x-app.job-center.incoming-message label="Jane, Jim and Trent all look fantastic." name="TI" time="Today, 1:31pm"/>
                <x-app.job-center.incoming-message label="Jim and Trent look good but they don't have optimal accredidation and have not provided all references yet-we ideally need to interview asap for this role" name="TI" time="Today, 1:34pm"/>
                <x-app.job-center.outgoing-message label="I agree, Jane looks great" name="LE" time="Today, 2pm"/>
            </div>
            <hr class="-mx-10 lg:block hidden"/>
            <div class="lg:h-20 pt-5 flex lg:flex-row flex-col lg:justify-between lg:items-start items-end">
                <div class="flex gap-5 items-center w-full lg:w-fit">
                    <x-input.text id="admin_search" name="admin_search"></x-input.text>
                    <x-button.outline class="lg:block hidden">Search</x-button.outline>
                </div>
                <x-button.outline class="lg:mt-0 mt-5">Post</x-button.outline>
            </div>
        </div>
    </div>

    <x-modal x-show="showDeclineAllConfirmation"
             x-on:click.outside="showDeclineAllConfirmation = false"
             onClose="showDeclineAllConfirmation = false">
        <div
            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="confirmation-title">
                        Decline All {{ count($selected_applicants) }} Applications
                    </h3>
                    <div class="mt-2">
                        <div>
                            <p>Are you sure you want to decline these applications? Please note, this will:</p>
                            <ul class="flex flex-col gap-3">
                                <li>Send an email to each candidate</li>
                                <li>Each panel member will be notified</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button @click="$wire.dispatch('declineAll'); showDeclineAllConfirmation = false" type="button"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                    Decline
                </button>
                <button @click="showDeclineAllConfirmation = false" type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Cancel
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal x-show="showBulkEmailModal" x-on:click.outside="showBulkEmailModal = false" onClose="showBulkEmailModal = false">
        <livewire:application.ats.bulk-email-form wire:model="selected_applicants"/>
    </x-modal>

    <x-modal x-show="showPanelEmailModal" x-on:click.outside="showPanelEmailModal = false" onClose="showPanelEmailModal = false">
        <livewire:application.ats.panel-email-form :job="$job" />
    </x-modal>

    <livewire:application.ats.modals.ats_modals :job="$job" wire:key="ats_modals" />

</div>
