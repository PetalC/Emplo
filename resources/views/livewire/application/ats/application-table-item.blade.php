@php use App\Enums\ApplicationStatuses; @endphp
<div
    x-data="{
        showHireApplicantConfirmation: false,
        showEmailApplicantModal:false,
        isSelected: $wire.entangle('selected').live,
    }"
    :class="isSelected ? 'border-green-600 bg-green-50' : 'border-gray-200'"
    class="grid justify-center items-center justify-items-center grid-cols-subgrid col-span-1 md:col-span-2 xl:col-span-12 border rounded-lg pl-6 pr-6 pt-4 pb-6"
    wire:loading.class="opacity-50"
>
    {{-- Allow livewire to interact with alpine to close modals after components function etc --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('update_ats_table', (event) => {
                let showHireApplicantConfirmation = false;
                let showEmailApplicantModal = false;
            });
        });
    </script>

    <div class="col-span-1 md:col-span-3 flex flex-col md:flex-row items-center justify-between xl:border-r xl:border-r-gray-200 w-full">

        <div class="flex items-center gap-6 w-full pr-3">

            <input type="checkbox" id="applicant-{{ $application->id }}" x-model="isSelected" class="accent-primary app-checkbox">

            <div class="flex flex-col gap-2 flex-grow">

                <div class="flex gap-2 items-center">
                    <a target="_blank" class="flex gap-2 items-center" href="{{ route('profile.view', $application->user) }}">
                        {{ $application->user->name }}
                        <x-icon name="heroicon-o-exclamation-circle" class="w-5 h-5"/>
                    </a>
                </div>

                <div class="text-gray-400 bg-white bg-opacity-50">{{ $application->user->profile?->city }}, {{ $application->user->profile?->state }}
                @if(!is_null($applicant_distance))
                    <p><small>( {{ $applicant_distance }} kms )</small></p>
                @endif
                </div>

                <livewire:application.status-indicator :application="$application"/>

            </div>

            <div class="justify-self-end min-w-6">
                @if( $user_flagged )
{{--                    @php $flagged_by = \App\Models\User::find( $user_flagged['pivot']['flagged_by'] ); @endphp--}}
{{--                    User Flagged has the flagged_by and flagged_at fields, we can potentially have a nice popup with a reason (yet to be added functionality, but guarantee it'll be in a future release) and the ability to remove the flag--}}
{{--                    title="Flagged By {{ $flagged_by->name }} on {{ \Carbon\Carbon::parse( $user_flagged['pivot']['flagged_at'] )->format( 'F jS, Y' ) }}"--}}
                    <x-icon name="heroicon-s-flag" class="w-6 h-6 p-1 text-red-500 border rounded" />
                @endif
            </div>

        </div>

    </div>

    <div class="md:col-span-2 p-4 mx-auto xl:mx-0">
        <livewire:application.panel-review :application="$application"/>
    </div>

    <div class="md:col-span-2 mx-auto xl:mx-0 mb-4 xl:mb-0">
        <x-app.user.badges :user="$application->user" class="bg-opacity-50"/>
    </div>

    <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
        <livewire:application.registrations :application="$application"/>
    </div>

    <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
        <livewire:application.documents wire:key="application_documents_{{ $application->id }}" :application="$application"/>
    </div>


    <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
        <livewire:application.interview :application="$application"/>
    </div>

    <div class="md:col-span-1 mx-auto xl:mx-0 my-2 xl:my-0">
        <livewire:application.references :application="$application"/>
    </div>

    <div class="md:col-span-1 md:col-span-2 lg:col-span-1 mx-auto flex justify-center xl:mx-0 my-2 xl:my-0">
        <x-select.dropdown icon="heroicon-o-ellipsis-horizontal" label="" class="rounded text-black p-2 cursor-pointer">
            {{-- Unable to shortlist a hired, declined or shortlisted application  --}}
            @if(!in_array($application->status, [ApplicationStatuses::STATUS_SHORTLISTED, ApplicationStatuses::STATUS_DECLINED, ApplicationStatuses::STATUS_HIRED]))
                <div class="flex cursor-pointer" wire:click="shortlistApplicant">
                    <x-icons.plus class="w-6 h-6 text-gray-500 pr-3"/>
                    <span class="text-center">Shortlist</span>
                </div>
            @endif
            @if($application->status == ApplicationStatuses::STATUS_SHORTLISTED)
                <div class="flex cursor-pointer" wire:click="unlistApplicant">
                    <x-icons.speech class="w-6 h-6 text-gray-500 pr-3"/>
                    <span class="text-center">Unlist</span>
                </div>
            @endif
            <div class="flex cursor-pointer" @click="showEmailApplicantModal = true">
                <x-icons.envelope class="w-6 h-6 text-gray-500 pr-3"/>
                <span class="text-center">Email</span>
            </div>
                {{-- TODO: Interview support --}}
{{--            @if($application->interviews->isEmpty())--}}
{{--                <div class="flex" wire:click="scheduleInterview">--}}
{{--                    <x-icons.calendar class="w-6 h-6 text-gray-500 pr-3"/>--}}
{{--                    <span class="text-center">Book</span>--}}
{{--                </div>--}}
{{--            @endif--}}

                {{-- Unable to decline declined or hired applications --}}
            @if(!in_array($application->status, [ApplicationStatuses::STATUS_DECLINED, ApplicationStatuses::STATUS_HIRED]))
            <div class="flex cursor-pointer" wire:click="declineApplicant">
                <x-icons.x-mark class="w-6 h-6 text-gray-500 pr-3"/>
                <span class="text-center">Decline</span>
            </div>
            @endif
            @if($application->status == ApplicationStatuses::STATUS_DECLINED)
                <div class="flex cursor-pointer" wire:click="reapproveApplicant">
                    <x-icons.speech class="w-6 h-6 text-gray-500 pr-3"/>
                    <span class="text-center">Reapprove</span>
                </div>
            @endif
            {{-- Unable to hire declined or hired applications --}}
            {{-- Only allow hiring if there is no one already hired --}}
            @if(!in_array($application->status, [ApplicationStatuses::STATUS_DECLINED, ApplicationStatuses::STATUS_HIRED])
                && !$hasHiredApplicant)
                <div class="flex cursor-pointer" @click="showHireApplicantConfirmation = true">
                    <x-icons.check-mark class="w-6 h-6 text-gray-500 pr-3"/>
                    <span class="text-center">Hire</span>
                </div>
            @endif
            @if($application->status == ApplicationStatuses::STATUS_HIRED)
                <div class="flex cursor-pointer" wire:click="reconsiderApplicant">
                    <x-icons.speech class="w-6 h-6 text-gray-500 pr-3"/>
                    <span class="text-center">Reconsider</span>
                </div>
            @endif
        </x-select.dropdown>
    </div>

    <x-modal x-show="showEmailApplicantModal"
             x-on:click.outside="showEmailApplicantModal = false"
             onClose="showEmailApplicantModal = false"
             :application="$application">
        <livewire:application.ats.email-form :application="$application"/>
    </x-modal>

    <x-modal x-show="showHireApplicantConfirmation"
             x-on:click.outside="showHireApplicantConfirmation = false"
             onClose="showHireApplicantConfirmation = false"
             :application="$application">
        <div class="sm:flex sm:items-start">
            <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icons.check-mark/>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="confirmation-title">
                    Hiring approval
                </h3>
                <div class="mt-2">
                    <p>You are about to approve the hiring of {{ $application->user->first_name}} for
                        the {{ $application->job->title }} role.</p>
                    <p>Please confirm you have completed the following.</p>
                </div>
                <livewire:application.approval.checklist :application="$application" :can-submit="$canSubmitHire"/>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button @click="{{ $canSubmitHire ?  "\$wire.dispatch('hire', { id: '".$application->id."' }); showHireApplicantConfirmation = false" : "console.log('hacked frontend')" }}" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 disabled:bg-gray-50 disabled:text-black sm:ml-3 sm:w-auto {{ $canSubmitHire ? null : 'disabled' }}"
                        {{ $canSubmitHire ? null : 'disabled' }}
                    >
                        Hire
                    </button>
                </div>
            </div>
        </div>
    </x-modal>

    {{--    <x-app.applicants.action.email-applicant/>--}}
    {{--        <x-app.applicants.action.schedule-interview :application="$application" :show="$showScheduleInterviewForm" />--}}
    {{--    <x-app.applicants.action.flag-applicant :application="$application" :show="$showFlagConfirmation" />--}}
    {{--    <x-app.applicants.action.hiring-approval-alert :application="$application" :show="$showHireConfirmation" :can-submit="$canSubmitHire" />--}}


</div>
