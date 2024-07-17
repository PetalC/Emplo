<div class="gap-10 w-full">
    <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10">
        <div class="flex flex-col md:grid md:grid-cols-6 md:flex-row gap-x-5 gap-y-16">

            <div class="md:col-span-3">
                <x-input.outline id="first_name" name="first_name" label="First name" placeholder="Your first name" wire:model.live.debounce.1000ms="fields.first_name" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="last_name" name="last_name" label="Last name" placeholder="Your last name" wire:model.live.debounce.1000ms="fields.last_name" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="phone_number" name="phone_number" label="Phone number" placeholder="Your phone number" wire:model.live.debounce.1000ms="fields.mobile_number" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="email" name="email" label="Email address" placeholder="Your email address" wire:model.live.debounce.1000ms="fields.email" />
            </div>

            <div class="md:col-span-2">
                <x-input.select id="country" name="country" label="Country" placeholder="Country" :options="$country_options" wire:model.live="fields.country" />
            </div>

            <div class="md:col-span-2" wire:loading.class="opacity-50" wire:target="fields.country">
                <x-input.select id="state" name="state" label="State" placeholder="State" :options="$state_options" wire:model.live="fields.state" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="suburb" name="suburb" label="Suburb" placeholder="Suburb" wire:model.live.debouce.1000="fields.city" />
            </div>

            <div class="col-span-6">
                @php $error_message = $errors->has('fields.specialities') ? $errors->first('fields.specialities') : false; @endphp
                <livewire:forms.multi-select wire:key="specialities_picker" label="Specialisation Subjects" :error_message="$error_message" class="w-full" model="{{ \App\Models\Subject::class }}" :options="$specialities_preselect" wire:model.live="fields.specialities" :with_search="true" />
                {{--                <x-input.outline id="specialists" name="specialists" label="Speciality areas" placeholder="eg. French, Mathematics, Support Staff, Cleaner, Principal" wire:model.blur="application_details.specialities" />--}}
            </div>

            <div class="md:col-span-3">
                <x-input.select id="work_right" name="work_right" label="Do you have the right to work in Australia?" :options="[ 1 => 'Yes', 0 => 'No']" wire:model.live="fields.right_to_work" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="location" name="location" label="I am currently" placeholder="Current Occupation" :associative="false" :options="$current_occupation_options" wire:model.live="fields.current_occupation" />
            </div>

            <div class="md:col-span-2">
                <x-input.select id="license" name="license" label="Registration/Licensing" placeholder="Registration/Licencing" :associative="false" :options="$authority_types" wire:model.blur="fields.registration_licence" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="registration_number" name="registration_number" label="Registration Number" placeholder="eg. 1002 9147" wire:model.blur="fields.registration_licence_number" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="registration_expiry" name="registration_expiry" label="Registration expiry" placeholder="eg. 05/{{ date('y') }}" wire:model.blur="fields.registration_licence_expiry" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="job_preferrence" name="job_preferrence" label="Preferred Job Type" placeholder="Preferred Job Type" :associative="false" :options="[ \App\Enums\JobType::FULLTIME->value, \App\Enums\JobType::PARTTIME->value ]" wire:model.live="fields.job_type" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="referred" name="referred" label="How did you learn about this opportunity?" placeholder="How did you learn about this opportunity?" :associative="false" :options="$application_source_options" wire:model.live="fields.referred_method" />
            </div>

            <div class="md:col-span-6">
                <x-app.job.apply.suitability-declaration />
            </div>

            <div class="md:col-span-6">
                <x-input.checkbox id="delaration" name="delaration" :value="true" label="I have read the Suitability Declaration and declare myself suitable for this role" wire:model.live="fields.suitable_declared" />
            </div>

{{--            <div class="md:col-span-6">--}}
{{--                <x-input.checkbox id="save_details" name="save_details" :value="true" label="Save my details for future job applications" wire:model.live="fields.save_details" />--}}
{{--            </div>--}}

        </div>

    </div>

    <div>
        <div class="flex justify-center gap-4 mt-10">
{{--            <div></div>--}}
{{--            <x-buttons.secondary wire:click="$parent.previousStep()">Back</x-buttons.secondary>--}}
            @if( in_array( $this->application?->validated_step, [ 'criteria', 'documents' ] ) )
                <x-buttons.primary size="xl" :shadow="false" wire:click="$parent.nextStep()">Supporting Documentation</x-buttons.primary>
            @else
                <x-buttons.primary size="xl" :shadow="false" class="opacity-50 cursor-not-allowed pointer-events-none" disabled>Supporting Documentation</x-buttons.primary>
            @endif
        </div>
    </div>

</div>
