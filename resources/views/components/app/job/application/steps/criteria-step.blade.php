<div class="gap-10 w-full pt-20">
    <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10">
        <div class="flex flex-col md:grid md:grid-cols-6 md:flex-row gap-x-5 gap-y-16">

            <div class="md:col-span-3">
                <x-input.outline id="first_name" name="first_name" label="First name" placeholder="Your first name" wire:model.blur="user_details.first_name" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="last_name" name="last_name" label="Last name" placeholder="Your last name" wire:model.blur="user_details.last_name" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="phone_number" name="phone_number" label="Phone number" placeholder="Your phone number" wire:model.blur="user_details.phone" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="email" name="email" label="Email address" placeholder="Your email address" wire:model.blur="user_details.email" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="suburb" name="suburb" label="Suburb" placeholder="Suburb" wire:model.blur="user_details.suburb" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="state" name="state" label="State" placeholder="State" wire:model.blur="user_details.state" />
            </div>

            <div class="md:col-span-2">
                <x-input.select id="country" name="country" label="Country" placeholder="Country" :options="['Australia' => 'Australia', 'New Zealand' => 'New Zealand']" wire:model.blur="user_details.country" />
            </div>

            <div class="col-span-6">
                @php $error_message = $errors->has('application_details.specialities') ? $errors->first('application_details.specialities') : false; @endphp
                <livewire:forms.multi-select wire:key="specialities_picker" label="Specialisation Subjects" :error_message="$error_message" class="w-full" model="{{ \App\Models\Subject::class }}" :options="App\Models\Subject::all()->take( 15 )->pluck( 'name', 'id' )->toArray()" wire:model.live="application_details.specialities" :with_search="true" />
{{--                <x-input.outline id="specialists" name="specialists" label="Speciality areas" placeholder="eg. French, Mathematics, Support Staff, Cleaner, Principal" wire:model.blur="application_details.specialities" />--}}
            </div>

            <div class="md:col-span-3">
                <x-input.select id="work_right" name="work_right" label="Do you have the right to work in Australia?" :options="[ 'Yes' => 'Yes', 'No' => 'No']" wire:model.blur="application_details.right_to_work" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="location" name="location" label="I am currently" placeholder="Current Location" :options="['Australia' => 'Australia', 'New Zealand' => 'New Zealand']" wire:model.blur="application_details.current_location" />
            </div>

            <div class="md:col-span-2">
                <x-input.select id="license" name="license" label="Registration/Licensing" placeholder="Registration/Licencing" :associative="false" :options="\App\Enums\LicencingAuthorityTypes::cases()" wire:model.blur="user_details.registration.licence" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="registration_number" name="registration_number" label="Registration Number" placeholder="eg. 1002 9147" wire:model.blur="user_details.registration.licence_number" />
            </div>

            <div class="md:col-span-2">
                <x-input.outline id="registration_expiry" name="registration_expiry" label="Registration expiry" placeholder="eg. 05/{{ date('y') }}" wire:model.blur="user_details.registration.licence_expiry" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="job_preferrence" name="job_preferrence" label="Preferred Job Type" placeholder="Preferred Job Type" :options="['1' => 'Job 1', '2' =>'Job 2']" wire:model.blur="application_details.job_type" />
            </div>

            <div class="md:col-span-3">
                <x-input.select id="referred" name="referred" label="How did you learn about this opportunity?" placeholder="How did you learn about this opportunity?" :options="['Friend' => 'Friend', 'Foe' => 'Foe']" wire:model.blur="application_details.referred_method" />
            </div>

            <div class="md:col-span-6">
                <x-app.job.apply.suitability-declaration />
            </div>

            <div class="md:col-span-6">
                <x-input.checkbox id="delaration" name="delaration" :value="true" label="I have read the Suitability Declaration and declare myself suitable for this role" wire:model.blur="declared_suitable" />
            </div>
        </div>

    </div>
</div>
