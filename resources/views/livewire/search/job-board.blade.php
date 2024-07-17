<div class="flex flex-col gap-6"
     x-data="{ showMap: $wire.entangle( 'display_map' ), at_top: true }"
     @scroll.window="at_top = (window.pageYOffset > 0 ? false : true)"
>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-12 items-center justify-items-center lg:gap-2 gap-0 justify-between mb-8">

        {{-- position --}}
        <x-app.search.filter label="Position" image="Search-Jobs-1-Position.png" :class="empty( $filters['positions'] ) ? 'border-transparent' : 'border-gray-200'">
            <x-input.outline wire:model.live.debounce.200ms="search_position_filters" placeholder="Search positions" />
            @forelse($positions as $position)
                <x-select.option wire:click="toggleFilter( 'positions', {{ $position->id }}, '{{ $position->name }}' )" :active="array_key_exists($position->id, $filters['positions'])">
                    {{ $position->name }}
                </x-select.option>
            @empty
                <x-select.option :active="false" >
                    {{ $noTaxonomyResultsText }}
                </x-select.option>
            @endforelse
        </x-app.search.filter>

        {{-- subject --}}
        <x-app.search.filter label="Subject" image="Search-Jobs-2-Subject.png" :class="empty( $filters['subjects'] ) ? 'border-transparent' : 'border-gray-200'">
            <x-input.outline wire:model.live.debounce.200ms="search_subject_filters" placeholder="Search subjects" />
            @forelse($subjects as $subject)
                <x-select.option wire:click="toggleFilter( 'subjects', {{ $subject->id }}, '{{ $subject->name }}' )" :active="array_key_exists($subject->id, $filters['subjects'])">
                    {{ $subject->name }}
                </x-select.option>
            @empty
                <x-select.option :active="false" >
                    {{ $noTaxonomyResultsText }}
                </x-select.option>
            @endforelse
        </x-app.search.filter>

        {{-- work type --}}
        <x-app.search.filter label="Work Type" image="Search-Jobs-3-WorkType.png" :class="empty( $filters['work_types'] ) ? 'border-transparent' : 'border-gray-200'">
{{--            <x-input.outline wire:model.live.debounce.200ms="search_work_type_filters" placeholder="Search work type" />--}}
            @forelse($workTypes as $workType)
                <x-select.option wire:click="toggleFilter( 'work_types', '{{ $workType->value }}', '{{ $workType->value }}' )" :active="array_key_exists($workType->value, $filters['work_types'])">
                    {{ $workType->value }}
                </x-select.option>
            @empty
                <x-select.option :active="false" >
                    {{ $noTaxonomyResultsText }}
                </x-select.option>
            @endforelse
        </x-app.search.filter>

        {{-- length --}}
        <x-app.search.filter label="Length" image="Search-Jobs-4-Length.png" :class="empty( $filters['length'] ) ? 'border-transparent' : 'border-gray-200'">
            <x-input.outline wire:model.live.debounce.200ms="search_job_length_filters" placeholder="Search lengths" />
            @forelse($lengths as $length)
                <x-select.option wire:click="toggleFilter( 'length', {{ $length->id }}, '{{ $length->name }}' )" :active="array_key_exists( $length->id, $filters['length'])">
                    {{ $length->name }}
                </x-select.option>
            @empty
                <x-select.option :active="false" >
                    {{ $noTaxonomyResultsText }}
                </x-select.option>
            @endforelse
        </x-app.search.filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.starting_soon ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.starting_soon', ! $wire.filters.starting_soon )"
            label="Starting Soon"
            icon="heroicon-o-user"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-5-StartingSoon.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.display_map ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'display_map', ! $wire.display_map )"
            label="On A Map"
            icon="heroicon-o-map-pin"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-6-NearMe.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.location_metro ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.location_metro', ! $wire.filters.location_metro )"
            label="Metro"
            icon="heroicon-o-building-office-2"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-7-Metropolitan.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.location_regional ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.location_regional', ! $wire.filters.location_regional )"
            label="Regional"
            icon="lucide-trees"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-8-Regional.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.location_coastal ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.location_coastal', ! $wire.filters.location_coastal )"
            label="Coastal"
            icon="iconoir-sea-and-sun"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-9-Coastal.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.relocation ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.relocation', ! $wire.filters.relocation )"
            label="Relocation"
            icon="carbon-delivery"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Job-10-Relocation.png') }}" />
        </x-app.search.boolean-filter>

        <x-app.search.boolean-filter
            x-bind:class="$wire.filters.housing ? 'border-gray-200' : 'border-transparent'"
            @click="$wire.set( 'filters.housing', ! $wire.filters.housing )"
            label="Housing"
            icon="carbon-delivery"
        >
            <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Jobs-11-Housing.png') }}" />
        </x-app.search.boolean-filter>

        {{-- curriculum --}}
        <x-app.search.filter label="Curriculum" icon="heroicon-o-bookmark" :class="empty( $filters['curriculum'] ) ? 'border-transparent' : 'border-gray-200'">
            <x-input.outline wire:model.live.debounce.200ms="search_curriculum_filters" placeholder="Search curricula" />
            @forelse($curricula as $curriculum)
                <x-select.option  wire:click="toggleFilter( 'curriculum', {{ $curriculum->id }}, '{{ $curriculum->name }}' )" :active="array_key_exists($curriculum->id, $filters['curriculum'])">
                    {{ $curriculum->name }}
                </x-select.option>
            @empty
                <x-select.option :active="false" >
                    {{ $noTaxonomyResultsText }}
                </x-select.option>
            @endforelse
        </x-app.search.filter>
    </div>

    @if( $display_map )
        <livewire:search.map :markers="$markers" key="search_map_jobs" />
    @endif

{{--     job board--}}
    <div class="flex flex-col gap-8 mb-8 mt-4 px-5 4xl:px-0" wire:loading.class="opacity-25">
        @forelse($jobs as $job)
            <livewire:search.job-card :key="'job_' . $job->id" :job="$job" />
        @empty
            <div class="flex flex-col pb-20 text-gray-600 gap-20 p-5 items-center">
                <h3 class="text-6xl text-center">
                    Unable to find <span class="text-primary">your dream job?</span> Get in touch!
                </h3>
                <x-buttons.primary elem_type="link" href="{{ route('contact') }}" size="lg">Contact Us</x-buttons.primary>
            </div>
        @endforelse
{{--        <div>--}}
{{--            {{ $jobs->links(data: ['scrollTo' => false]) }}--}}
{{--        </div>--}}
    </div>
</div>


