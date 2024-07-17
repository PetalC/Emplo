@props([
    'bulkDisabled' => false,
    'disabledHire' => false,
    'selected_applicants' => []
])

@php
$modal_params = array_keys( array_filter( $selected_applicants, fn( $applicant ) => $applicant != false  ) );
@endphp

<div class="mt-12 px-20">

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-10 gap-6">

        <div wire:click="selectAllApplicants"
            class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer">
            <x-icons.check-box class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Select All</span>
        </div>

        <div wire:click="deselectAllApplicants"
            class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.uncheck-box class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Unselect All</span>
        </div>

        <div wire:click="shortlistAllApplicants"
             class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.plus class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Shortlist</span>
        </div>

        <div @click="showDeclineAllConfirmation = true"
            class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.x-mark class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Decline</span>
        </div>

        <div @click="showBulkEmailModal = true"
            class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.envelope class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Email Candidates</span>
        </div>

        <div @click="showPanelEmailModal = true" class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded {{ $bulkDisabled ? 'disabled cursor-not-allowed opacity-80' : 'cursor-pointer' }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.arrow-right class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Email Panel</span>
        </div>

{{--        --}}
        <div @click="$wire.dispatch( 'ats.open-modal', [ 'interview-applicant', '{{ json_encode( $modal_params ) }}' ] )" class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.speech class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Interview</span>
        </div>

        <div class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 opacity-50 rounded cursor-not-allowed {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <x-icons.star class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Request Referees</span>
        </div>

        <div class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded opacity-50 cursor-not-allowed {{ $bulkDisabled ? 'disabled' : null }}" {{ $bulkDisabled ? 'disabled' : null }}>
            <div class="flex gap-1">
                <x-icons.star class="w-6 h-6 text-gray-500" />
                <x-icons.arrow-right class="w-6 h-6 text-gray-500" />
            </div>
            <span class="text-xs text-gray-500 whitespace-nowrap">Conduct References</span>
        </div>

        <div @click="$wire.dispatch( 'ats.open-modal', [ 'hire-applicant', '{{ json_encode( $modal_params ) }}' ] )" class="flex flex-col gap-3 justify-between items-center px-3 py-4 bg-gray-100 rounded cursor-pointer {{ $disabledHire ? 'disabled' : null }}" {{ $disabledHire ? 'disabled' : null }}>
            <x-icons.check-mark class="w-6 h-6 text-gray-500" />
            <span class="text-xs text-gray-500">Hire Candidates</span>
        </div>

    </div>

</div>
