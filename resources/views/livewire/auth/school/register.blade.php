<div class="grid grid-cols-4 gap-10 w-full py-20">
    <div class="col-start-1 col-span-12 pr-20 pl-20 md:pl-0 md:pr-0 md:col-start-2 md:col-span-2 flex flex-col gap-10">
        <h5 class="font-bold text-2xl text-center md:text-left">Register</h5>

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

            <livewire:forms.search-select
                id="your_school"
                name="your_school"
                label="Your School"
                placeholder="Search for your school"
                :model="\App\Models\School::class"
                wire:model.live="yourSchool" />

            <x-input.select
                id="your_position"
                name="your_position"
                label="Your Position"
                :associative="false"
                :options="[
                    'Principal',
                    'Deputy Principal',
                    'Director',
                    'Business Manager',
                    'EA/PA to the Principal/Senior Leadership Team',
                    'Senior Leadership Team',
                    'People and Culture and Manager',
                    'People and Culture and Officer',
                    'Human Resources Manager',
                    'Human Resources Officer',
                    'Talent Acquisition Specialist',
                    'Compliance and Safeguarding Officer',
                    'Head of Department/Faculty',
                    'Marketing Manager',
                    'School Marketing Representative',
                    'Diocese or Authority Representative',
                    'Bursur',
                    'Boardmember',
                    'Other'
                ]"
                wire:model.blur="yourPosition"
            />
        </div>

        <div class="flex items-center flex-col md:flex-row justify-end">

            <x-button.primary
                size="lg"
                wire:click="register"
                wire:loading.attr="disabled"
            >
                <span wire:loading wire:target="register">Wait...</span>
                <span wire:loading.remove wire:target="register">Register</span>
            </x-button.primary>
        </div>
    </div>
</div>
