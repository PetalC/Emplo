<div class="grid grid-cols-4 gap-10 w-full py-20">
    <div class="col-start-1 col-span-12 pl-10 pr-10 md:pr-0 sm:pl-0 md:col-start-2 md:col-span-2 flex flex-col gap-10">
        <h5 class="font-bold text-2xl text-left">Register</h5>

        <div class="flex flex-col md:grid md:grid-cols-2 md:flex-row gap-x-5 gap-y-10">
            <x-input.outline
                id="first_name"
                name="first_name"
                label="First name"
                placeholder="Your first name"
                wire:model.blur="firstName"
            />

            <x-input.outline
                id="last_name"
                name="last_name"
                label="Last name"
                placeholder="Your last name"
                wire:model.blur="lastName"
            />

            <x-input.outline
                id="phone_number"
                name="phone_number"
                label="Phone number"
                placeholder="Your phone number"
                wire:model.blur="phoneNumber"
            />

            <x-input.outline
                id="r_email"
                name="r_email"
                label="Email address"
                placeholder="Your email address"
                wire:model.blur="email"
            />

            <x-input.outline
                id="r_password"
                name="r_password"
                type="password"
                label="Create password"
                placeholder="Enter your new password"
                wire:model.blur="password"
            />

            <x-input.outline
                id="password2"
                name="password2"
                type="password"
                label="Confirm password"
                placeholder="Confirm your new password"
                wire:model.blur="password2"
            />

            <x-input.select
                id="work_right"
                name="work_right"
                label="Do you have the right to work in Australia?"
                :options="['Yes', 'No']"
                wire:model.blur="rightWorkInAU"
            />

            <x-input.select
                id="location"
                name="location"
                label="I am currently"
                :associative="false"
                :options="$current_occupation_options"
                wire:model.blur="occupation"
            />

            <div class=" col-span-2">
                <livewire:forms.multi-select
                    wire:key="specialities_picker"
                    wire:model.live="selected_specialities"
                    label="Speciality areas"
                    class="w-full"
                    :options="$specialities_options"
                    model="{{ \App\Models\Subject::class }}"
{{--                                    :error_message="{{ $errors->has( 'application_details.specialities' ) ? $errors->first( 'application_details.specialities' ) : false  }}"--}}
                    :with_search="true"
                />
            </div>

{{--            --}}{{-- TODO: Need to make this field as a select with badge items --}}
{{--            <div class="col-span-2">--}}
{{--                <x-input.outline --}}
{{--                    id="specialists" --}}
{{--                    name="specialists" --}}
{{--                    label="Speciality areas" --}}
{{--                    placeholder="eg. Frensh, Mathematics, Support Staff, Cleaner, Principal" --}}
{{--                    wire:model.blur="specialists"--}}
{{--                />--}}
{{--            </div>--}}
        </div>

        <div class="flex items-center flex-col justify-center md:flex-row justify-between">
            <x-input.checkbox
                id="tac"
                name="tac"
                label="I have read and accept the <a href='' class='cursor-pinter underline'>Terms & Conditions</a>"
                wire:model.blur="acceptTOS"
            />

            <x-button.primary
                size="lg"
                class="w-full mt-5 sm:mt-0 sm:w-auto"
                wire:click="register"
                wire:loading.attr="disabled"
            >
                <span wire:loading wire:target="register">Wait...</span>
                <span wire:loading.remove wire:target="register">Register</span>
            </x-button.primary>
        </div>
    </div>
</div>
