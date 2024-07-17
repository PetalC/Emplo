<div class="flex flex-col gap-5 justify-center">
    <x-icon name="heroicon-c-check-circle" class="w-52 h-52 text-primary cursor-pointer py-10 mx-auto" />
    <h2 class="text-center text-xl font-light">You have just applied for a <span class="font-bold">{{ $job->title }}</span> position at <span class="font-bold">{{ $job->school->name }}</span></h2>

    @if( ! $application->save_details )
        <div class="bg-gray-50 border-y border-y-gray-200 py-6 px-6 mt-4 flex flex-col gap-8">

            <h4 class="text-2xl font-light text-center">Would you like to save your application details and documents for future job applications?</h4>
            <h4 class="text-center">If you save your application details and documents we'll send you an email with a link to your profile where you can track your job applications, manage your profile, follow schools and much more.</h4>

            <div x-data="{ show_password_fields: false }" class="flex flex-col gap-8">

                <div class="flex justify-center">
                    <x-buttons.primary x-show="! show_password_fields" size="xl" :shadow="false" @click="show_password_fields = true">Save Application</x-buttons.primary>
                </div>

                <div x-show="show_password_fields" class="flex justify-center gap-4" >
                    <x-input.outline wire:model.live.debounce.500="password" label="Please enter a password for your account" placeholder="Password" type="password" />
                    <x-input.outline wire:model.live.debounce.500="password_confirmation" label="Confirm Password" placeholder="Confirm Password" type="password" />
                </div>

                <div x-show="show_password_fields" class="flex justify-center gap-4" >
                    <x-buttons.secondary x-show="show_password_fields" size="xl" :shadow="false" @click="show_password_fields = false">Cancel</x-buttons.secondary>
                    <x-buttons.primary x-show="show_password_fields" size="xl" :shadow="false" wire:click="saveApplication">Save Application</x-buttons.primary>
                </div>

            </div>

        </div>
    @endif

    @if( $save_application_complete )
        <div class="bg-gray-50 border-y border-y-gray-200 py-6 px-6 mt-4 flex flex-col gap-8">
            <h4 class="text-2xl font-light text-center">Your application details and documents have been saved</h4>
            <h4 class="text-center">We have sent you an email with a link to your profile where you can track your job applications, manage your profile, follow schools and much more.</h4>
        </div>
    @endif

</div>
