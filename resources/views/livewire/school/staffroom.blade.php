<div>
    <div class="lg:px-0 px-20 max-w-8xl mx-auto">

        <x-app.common.page_header mobileMenuSelectedIndex='2'>
            <x-slot name="column_left">
                <x-app.school.avatar class="max-w-56" :campus="$campus" />
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.campus_profile' ) }}" class="w-full max-w-56 mb-4 mt-6 flex justify-center py-3 !font-light !text-xl">Update Profile</x-buttons.secondary>
            </x-slot>

            <x-text.heading class="mt-12 text-center w-full" variant="h1">{{ $campus->primary_profile->name }}</x-text.heading>
            <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 text-center w-full lg:block hidden">Candidate Database</x-text.heading>
{{--        <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 text-center w-full lg:block hidden"><pre>{{ print_r($debug, true) }}</pre></x-text.heading>--}}

        </x-app.common.page_header>

        {{-- Table --}}
        <div class="w-full mt-20 mb-20">
            <div class="flex justify-between">
                <p class="text-app text-3xl lg:block hidden"> Candidates </p>
                <div class="flex gap-5 w-full lg:w-fit justify-center lg:justify-start">
                    <div class="bg-gray-100 rounded-lg py-3 px-5 flex items-center gap-3 text-gray-500 cursor-pointer" wire:click="selectAllUsers">
                        <div class="rounded-lg border border-gray-600 p-1">
                            <x-icon name="heroicon-o-check" class="w-5 h-5"></x-icon>
                        </div>
                        <p> Select all </p>
                    </div>
                    <div class="bg-gray-100 rounded-lg py-3 px-5 flex items-center gap-3 text-gray-500 cursor-pointer" wire:click="unselectAllUsers">
                        <div class="rounded-lg border border-gray-600 p-1">
                            <x-icon name="heroicon-c-x-mark" class="w-5 h-5"></x-icon>
                        </div>
                        <p> Unselect all </p>
                    </div>
                    <div class="bg-gray-100 rounded-lg py-3 px-5 flex items-center gap-3 text-gray-500 cursor-not-allowed opacity-40">
                        <div class="p-1">
                            <x-icon name="heroicon-o-envelope" class="w-7 h-7"></x-icon>
                        </div>
                        <p> Email candidate(s) </p>
                    </div>
                </div>
            </div>
            <div class="w-full flex lg:flex-row flex-col mt-10 gap-20">
                <div class="lg:w-1/4 w-full flex flex-col gap-10" x-data="{ openFilter: true }">
                    <div class="flex lg:hidden justify-between" x-on:click="openFilter = !openFilter">
                        <p class="text-xl font-bold text-app">Filters</p>
                        <x-icon x-show="openFilter" name="heroicon-c-chevron-up" class="w-5 h-5" />
                        <x-icon x-show="!openFilter" name="heroicon-c-chevron-down" class="w-5 h-5" />
                    </div>
                    <div class="flex flex-col gap-10" x-show="openFilter">

                        <x-input.select id="filter_candidate" name="filter_candidate" wire:model.live="filters.candidateType" label="Candidate type" :associative="false" :options="$candidateTypes" placeholder="Choose option"></x-input.select>
                        <x-input.select id="filter_country" wire:model.live="filters.country" name="filter_country" label="Country" :options="$countries" placeholder="Choose country"></x-input.select>
                        <x-input.select id="filter_state" wire:model.live="filters.state" name="filter_state" label="State" :options="$states" placeholder="Choose state"></x-input.select>
                        <x-input.select id="filter_city" name="filter_city" wire:model.live="filters.city" label="City" :options="$cities" placeholder="Choose option"></x-input.select>
                        <livewire:forms.multi-select label="Currently registered with" class="w-full" wire:model.live="filters.registered_with" :with_search="false" :options="$authority_types" />
                        <livewire:forms.multi-select label="Specialisation Subjects" class="w-full" model="{{ \App\Models\Subject::class }}" wire:model.live="filters.selected_subjects" :with_search="true" :options="$specialisation_options" />
                        <x-input.select id="filter_right_work" name="filter_right_work" wire:model.live="filters.rtw" label="Right to live and work" :options="$right_to_work_options" placeholder="Choose option"></x-input.select>
                        <x-input.select id="filter_supply_reference" wire:model.live="filters.supply_reference" name="filter_supply_reference" label="Can Supply Reference" :options="$supply_reference_options" placeholder="Choose option"></x-input.select>

                        <div class="hidden">
                            <x-input.outline id="filter_aspiration" class="hidden" name="filter_aspiration" label="Career aspirations" placeholder="Add tag"/>
                            <x-input.outline id="filter_job_type" class="hidden" name="filter_job_type" label="Job types" placeholder="Add tag"/>
                            <x-input.outline id="filter_job_length" class="hidden" name="filter_job_length" label="Job length" placeholder="Add tag"/>
                            <x-input.select id="supply_faith_reference" class="hidden" name="supply_faith_reference" label="Can supply a faith reference" :options="['A', 'B']" placeholder="Choose option"></x-input.select>
                            <x-input.select id="date_available" name="date_available"  class="hidden" label="Date available" :options="['A', 'B']" placeholder="Choose option"></x-input.select>
                            <x-input.outline id="filter_career" name="filter_career" label="Current areas of work" placeholder="Add tag"/>
                        </div>


                    </div>
                </div>
                <div class="lg:w-3/4 w-full">


                    <div class="grid grid-cols-12 gap-4">
                        <div class="lg:grid lg:grid-cols-subgrid col-span-12 hidden mb-5">
                            <div class="col-span-1"></div>
                            <p class="font-bold col-span-5">Name</p>
{{--                            <p class="font-bold col-span-3">Proximity</p>--}}
                            <p class="font-bold col-span-3">Skills</p>
                            <p class="font-bold col-span-3">Safeguarding</p>
                        </div>

                        @foreach($followers as $follower)
                          <livewire:school.follower-card wire:key="follower_{{ $follower->id }}" wire:model="selected_users.{{ $follower->id }}" :user="$follower"  />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
