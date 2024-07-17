<div class="lg:px-0 px-20">
    <x-app.job.page-header :job="$job" :is_ats="true">
        <x-slot name="column_left">
            <div class="text-app mt-5 w-full text-xl flex flex-col gap-2">
                <a href="{{ route('job', $job) }}" class="text-lg" ><div><x-icon name="heroicon-o-document-text" class="inline-block w-4 h-4 mr-3"/>View this Job Ad</div></a>
                <a href="{{ route('school.jobcenter.index') }}" class="text-lg"><div><x-icon name="heroicon-m-list-bullet" class="inline-block w-4 h-4 mr-3"/>View all jobs</div></a>
{{--                <div><x-icons.speech class="inline-block mr-3"/> Upcoming interviews</div>--}}
            </div>
        </x-slot>
        <x-slot name="column_right">
            <div class="flex flex-col items-center">
{{--                <x-buttons.secondary class="mt-16">Generate Report</x-buttons.secondary>--}}
{{--                <!-- Filter candidates -->--}}
{{--                <x-select.dropdown label="Filter Candidates" class="mt-2 md:mt-16" wire.model="filters">--}}
{{--                    <x-input.select id="filter_country" wire:model.live="filters.country" name="filter_country"--}}
{{--                                    label="Country" :options="$countries" placeholder="Choose country"></x-input.select>--}}
{{--                    <x-input.select id="filter_state" wire:model.change="filters.state" name="filter_state" label="State" :options="$states" placeholder="Choose state"></x-input.select>--}}
{{--                </x-select.dropdown>--}}
                <div class="mb-4 relative" x-data="{ open: false }">
                    <!-- Hoverable Filters Menu -->
                    <div
                        class="relative inline-block text-left"
                        @click="open = !open" >

                        <!-- Trigger -->
                        <x-buttons.secondary elem_type="link" class="w-full max-w-70 mb-4 mt-6 flex justify-center gap-4 py-3 !font-light !text-lg cursor-pointer"><span>Filter Candidates</span><x-icon name="heroicon-o-funnel" class="inline-block w-6 h-6 mr-3"/></x-buttons.secondary>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1">
                                @foreach($filters as $filter => $value)
                                    <div class="px-4 py-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model.live="filters.{{ $filter }}" class="mr-2">
                                            {{ ucwords(str_replace('-', ' ', $filter)) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-app.job.page-header>

    <div class="max-w-8xl mx-auto">
        @if( count($applications) )
            <span class="flex text-center text-gray-500 align-middle justify-center">{{ $unfiltered_total }} Applied
                @if(count($applications) < $unfiltered_total)
                    ({{ count($applications) }} filtered)
                @endif
            </span>
        @endif

        {{-- Filter key in ATS uses the state of the filter object to make the table refresh when filters are changed --}}
        <livewire:application.ats.application-table :job="$job" :applications="$applications" :key="$filterKey"/>

    </div>
</div>
