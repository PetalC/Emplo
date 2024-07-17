<div>

    <div x-data="{ open: @entangle( 'open_modal' ).live }">

        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false; $wire.call( 'clearFields' );">

            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Hiring Approval
            </h4>

            @if( $applications->isEmpty() )
                <h1 class="text-xl font-light mt-10 text-center">No Applicants Selected. Please select an applicant to proceed with hiring.</h1>
            @elseif( $is_complete )
                <h1 class="text-xl font-light mt-10 text-center">The selected applicants have successfully been approved for hiring.</h1>
            @else

                <div class="flex flex-col gap-4">
                    @foreach( $applications as $application )
                        <p>
                            You are about to approve the hiring of <span class="font-semibold">{{ $application->user->first_name }}</span> to the <span class="font-semibold">{{ $application->job->title }}</span> role.
                        </p>
                    @endforeach

                    <p>
                        Please confirm you have completed the following.
                    </p>

                </div>

                <div class="flex flex-col gap-4 pt-10 px-10">
                    <x-input.checkbox class="w-full" wire:model.live="reference_check" id="reference_check" label="All Required Reference Checks" />
                    <x-input.checkbox class="w-full" wire:model.live="licencing_check" id="licencing_check" label="Licencing / Registration" />
                    <x-input.checkbox class="w-full" wire:model.live="working_with_children_check" id="working_with_children_check" label="Working with Children Check" />
                    <x-input.checkbox class="w-full" wire:model.live="application_check" id="application_check" label="Application form (If Applicable)" />
                </div>

                <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm">Approve</x-buttons.primary>

            @endif

        </x-modal>

    </div>

</div>
