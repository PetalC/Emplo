<div class="max-w-8xl mx-auto flex flex-col text-secondary">

{{--    <x-app.profile.profile-header />--}}

    <x-app.common.page_header>
        <x-slot name="column_left">
            <div class="max-w-52">
                <x-app.profile.avatar url="{{ route( 'profile' ) }}" class="w-full justify-center flex !px-0 !py-0"/>

                <x-input.upload id="avatar_upload" class="mt-6 w-full overflow-hidden" id="school_application_form" wire:model.live="new_avatar" accept="image/*" >
                    <x-buttons.primary class="block px-2 !text-[15px] w-full whitespace-nowrap" :shadow="false">Update Profile Image</x-buttons.primary>
                </x-input.upload>
            </div>
        </x-slot>

        <x-text.heading variant="h1" class="my-14">My Profile</x-text.heading>
    </x-app.common.page_header>

    <div class="max-w-4xl mx-auto mt-10">

{{--        Header for a tabbed navigation. Will likely need this or something similar when we end up splitting this form into appropriate pages.--}}
{{--        <div>--}}
{{--            <div class="sm:hidden">--}}
{{--                <label for="tabs" class="sr-only">Select a tab</label>--}}
{{--                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->--}}
{{--                <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">--}}
{{--                    <option>Basic Information</option>--}}
{{--                    <option>Certifications</option>--}}
{{--                    <option>Team Members</option>--}}
{{--                    <option>Billing</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="hidden sm:block">--}}
{{--                <div class="border-b border-gray-200">--}}
{{--                    <nav class="-mb-px flex" aria-label="Tabs">--}}
{{--                        <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->--}}
{{--                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/4 border-b-2 py-4 px-1 text-center text-sm font-medium">Basic Details</a>--}}
{{--                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/4 border-b-2 py-4 px-1 text-center text-sm font-medium">More About You</a>--}}
{{--                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/4 border-b-2 py-4 px-1 text-center text-sm font-medium">Certifications</a>--}}
{{--                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 w-1/4 border-b-2 py-4 px-1 text-center text-sm font-medium">Education</a>--}}
{{--                        <a href="#" class="border-indigo-500 text-indigo-600 w-1/4 border-b-2 py-4 px-1 text-center text-sm font-medium" aria-current="page">Experience</a>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="grid grid-cols-6 gap-x-5 gap-y-10 w-full mb-20 px-6 xl:px-0">

            {{-- Personal Information --}}
            <div class="col-span-6 xl:col-span-3">
                <x-input.outline wire:model.live.debounce.400ms="fields.first_name" label="First name" placeholder="Your first name" />
            </div>

            <div class="col-span-6 xl:col-span-3">
                <x-input.outline class="col-span-3" wire:model.live.debounce.400ms="fields.last_name" label="Last name" placeholder="Your last name" />
            </div>

            <div class="col-span-6 xl:col-span-3">
                <x-input.outline class="col-span-3" wire:model.live.debounce.400ms="fields.phone_number" label="Phone number" placeholder="Your phone number" />
            </div>

            <div class="col-span-6 xl:col-span-3">
                <x-input.outline class="col-span-3" wire:model.live.debounce.400ms="fields.email" label="Email address" placeholder="Your email address" />
            </div>

{{--            <h5 class="font-bold text-lg col-span-6">Current Location</h5>--}}

            <div class="col-span-6 xl:col-span-2">
                <x-input.select wire:model.live="profile_fields.country" placeholder="Country" label="Country" :options="$available_countries" />
            </div>

            <div class="col-span-6 xl:col-span-2">
                <x-input.select wire:model.live="profile_fields.state" placeholder="State" label="State" :options="$available_states" />
            </div>

            <div class="col-span-6 xl:col-span-2">
                <x-input.outline wire:model.live="profile_fields.city" placeholder="City" label="City" />
            </div>

{{--            <div class="col-span-2 grid grid-cols-3 gap-x-5 items-end">--}}
{{--                --}}
{{--                --}}
{{--                --}}
{{--            </div>--}}

            <div class="col-span-6">
                <livewire:forms.multi-select wire:model.live="fields.specialities" label="Speciality areas" :with_search="true" :model="App\Models\Subject::class" :options="App\Models\Subject::all()->take( 10 )->pluck( 'name', 'id' )->toArray()" />
            </div>

            <div class="col-span-6 xl:col-span-3">
                <x-input.select wire:model.live="profile_fields.right_to_work" label="Do you have right to work in Australia?" :associative="false" :options="['No', 'Yes']" />
            </div>

            <div class="col-span-6 xl:col-span-3">
                <x-input.select wire:model.live="fields.citizenship" label="My Citizenship Status" :options="$citizenship_options" />
            </div>

            <div class="col-span-6 xl:col-span-2">
                <x-input.select wire:model.live="fields.registration_type" label="Registration/Licensing" :associative="false" :options="\App\Enums\LicencingAuthorityTypes::cases()" />
            </div>

            <div class="col-span-6 xl:col-span-2">
                <x-input.outline wire:model.live="fields.registration_number" label="Registration number" placeholder="eg. 1002 91487" />
            </div>

            <div class="col-span-6 xl:col-span-2">
                <x-input.outline wire:model.live="fields.registration_expiry" label="Registration expiry" placeholder="eg. 05/28" />
            </div>

            <div class="col-span-6 flex flex-col gap-2">
                <div class="flex items-center">
                    <label for="" class="block text-sm font-bold text-secondary">Salary Expectations</label>
                </div>

                <div class="flex justify-items-stretch gap-x-5 items-center">
                    <div class="flex-grow">
                        <x-input.select wire:model.live="profile_fields.minimum_salary" :associative="false" :options="$salary_ranges" />
                    </div>
                    <span class="text-secondary">to</span>
                    <div class="flex-grow">
                        <x-input.select class="flex-grow" wire:model.live="profile_fields.maximum_salary" :associative="false" :options="$salary_ranges" />
                    </div>
                </div>
            </div>

            <div class="col-span-6">
                <livewire:forms.multi-select wire:model.live="fields.current_position_types" label="I am currently working in/as" :with_search="false" :options="App\Models\PositionType::all()->pluck( 'name', 'id' )->toArray()" />
            </div>

            {{--                <div class="col-span-2">--}}
            {{--                    <x-input.outline id="i_am_currently_working_in" name="i_am_currently_working_in" label="I am currently working in/as" placeholder="eg. Taxonomies" />--}}
            {{--                </div>--}}

            {{--                <div class="col-span-2">--}}
            {{--                    <x-input.outline id="i_am_seeking_a_role_as" name="i_am_seeking_a_role_as" label="I am seeking a role as/or in" placeholder="eg. Taxonomies" />--}}
            {{--                </div>--}}

            <div class="col-span-6">
                <livewire:forms.multi-select wire:model.live="fields.preferred_position_types" label="My preferred job types are" :with_search="false" :options="App\Models\PositionType::all()->pluck( 'name', 'id' )->toArray()" />
            </div>

            <div class="col-span-6">
                <livewire:forms.multi-select wire:model.live="fields.preferred_job_lengths" label="My preferred job length is" :with_search="false" :options="App\Models\JobLength::all()->pluck( 'name', 'id' )->toArray()" />
            </div>

            <div class="col-span-6">
                <livewire:forms.multi-select wire:model.live="fields.preferred_school_types" label="My preferred school type is" :with_search="false" :options="App\Models\SchoolType::all()->pluck( 'name', 'id' )->toArray()" />
            </div>

            <div class="col-span-6">
                <x-input.select wire:key="faith_reference" wire:model.live="profile_fields.faith_reference" label="Can you supply a faith reference?" :associative="false" :options="['No', 'Yes']" />
            </div>

            <div class="col-span-6">
                <x-input.textarea wire:key="brief" class="text-xl font-weight-light" characterLimit="200" wire:model.live.debounce.1000="profile_fields.brief" label="Statement" rows="4" />
            </div>

            {{-- Experience --}}
            <h5 class="font-bold text-lg">Experience</h5>

            @foreach( $user->experiences as $experience )
                <div class="col-span-6">
                    <livewire:profile.edit-user-experience :key="'experience' . $experience->id" :experience="$experience" />
                </div>
            @endforeach

            <div class="col-span-6">
                <x-button.outline wire:click="addNewExperience()" class="font-bold col-span-2">Add Another Experience Description</x-button.outline>
            </div>

            {{-- Education --}}
            <h5 class="font-bold text-lg">Education</h5>

            @foreach( $user->educations as $education )
                <div class="col-span-6">
                    <livewire:profile.edit-user-education :key="'education' . $education->id" :education="$education" />
                </div>
            @endforeach

            <div class="col-span-6">
                <x-button.outline wire:click="addNewEducation()" class="font-bold col-span-2">Add Another Education Description</x-button.outline>
            </div>

            {{-- Certifications --}}
            <h5 class="font-bold text-lg">Certifications</h5>

            @foreach( $user->profile_certifications as $profile_certification )
                <div class="col-span-6">
                    <livewire:profile.edit-user-profile-certification :key="'certification_' . $profile_certification->id" :profile_certification="$profile_certification" />
                </div>
            @endforeach

            <div class="col-span-6">
                <x-button.outline wire:click="addNewCertification()" class="font-bold col-span-2">Add Another Certification</x-button.outline>
            </div>


            <div class="col-span-6 flex flex-col gap-5">
                <h5 class="block mb-2 text-sm font-bold text-secondary">School employment suitability declaration</h5>

                <ol class="list-decimal font-semibold text-sm ml-4">
                    <li>I declare the above is accurate and true and was completed in good faith to secure a job in a school; and</li>
                    <li>I understand the role and responsibilities of an employee working within a school setting where staff are directly or indirectly working with children and young people; and</li>
                    <li>I have undertaken child protection and reportable conduct training in the last twelve months; and</li>
                    <li>I am capable of carrying out the activities and upholiding the responsibilities required to safeguard for child protection purposes; and</li>
                    <li>I have not been suspended from or had any registration with a teacher liscensing authority cancelled due to child protection or conduct deemed reportable for child protection purposes; and</li>
                    <li>I have no criminal convictions in the past ten years. I understand that "conviction" is defined in the Criminal Records Act 1991 and includes a conviction, whether summary or an indictment for an offense, and includes a finding or order that an offence has been proved, or that a person is guilty of an offence, without proceeding to a conviction; and</li>
                    <li>I am not subject to any pending court proceedings relating to a criminal matter in Australia or overseas; and</li>
                    <li>
                        <p>I have no convictions that cannot become spent within the meaning of the Criminal Records Act 1991 including but not limited to:</p>
                        <div class="flex flex-col">
                            <p>a. convictions for which a prison sentence of more than six months has been imposed: or</p>
                            <p>b. convictions of sexual offences</p>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="col-span-6">
                <x-input.checkbox wire:model.live="profile_fields.suitable_for_work" label="I have read the Suitability Declaration and declare myself suitable." />
            </div>

            <div class="col-span-6">
                <x-button.primary @click="$wire.$call( 'validateAll' );" class="font-bold">Save</x-button.primary>
            </div>
        </div>
    </div>
</div>
