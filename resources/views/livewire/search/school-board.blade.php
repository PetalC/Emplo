<div class="flex flex-col gap-6"
     x-data="{ showMap: $wire.entangle( 'display_map' ) }"
>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-14 items-center justify-items-center lg:gap-2 gap-0 justify-between mb-8">

            <x-app.search.boolean-filter x-bind:class="$wire.filters.early_childhood ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.early_childhood', ! $wire.filters.early_childhood )" label="Early Childhood" icon="heroicon-o-user">
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-4-EarlyChildhood-ComingSoon.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.primary ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.primary', ! $wire.filters.primary )" label="Primary" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-3-Primary.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.secondary ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.secondary', ! $wire.filters.secondary )" label="Secondary" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-2-Secondary.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.p_12 ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.p_12', ! $wire.filters.p_12 )" label="P-12" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-1-P12.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.tertiary ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.tertiary', ! $wire.filters.tertiary )" label="Tertiary" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-14-Tertiary-ComingSoon.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.co_ed ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.co_ed', ! $wire.filters.co_ed )" label="Co-Ed" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-5-Coed.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.all_boys ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.all_boys', ! $wire.filters.all_boys )" label="All Boys" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-6-AllBoys.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.all_girls ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.all_girls', ! $wire.filters.all_girls )" label="All Girls" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-7-AllGirls.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.government ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.government', ! $wire.filters.government )" label="Government" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-8-Government.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.catholic ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.catholic', ! $wire.filters.catholic )" label="Catholic" icon="heroicon-o-user" >
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-9-Catholic.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.independent ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.independent', ! $wire.filters.independent )" label="Independent" icon="heroicon-o-user">
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-10-Independant.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.filter label="Religion" image="Search-Schools-11-Religion.png" :class="empty( $filters['religion'] ) ? 'border-transparent' : 'border-gray-200'">
                <x-input.outline wire:model.live.debounce.200ms="search_religion_filters" placeholder="Search religions" />
                @forelse($religions as $religion)
                    <x-select.option wire:click="toggleFilter( 'religion', {{ $religion->id }}, '{{ $religion->name }}' )" :active="array_key_exists( $religion->id, $filters['religion'])">
                        {{ $religion->name }}
                    </x-select.option>
                @empty
                    <x-select.option :active="false" >
                        {{ $noTaxonomyResultsText }}
                    </x-select.option>
                @endforelse
            </x-app.search.filter>

            <x-app.search.boolean-filter x-bind:class="$wire.filters.non_demominational ? 'border-gray-200' : 'border-transparent'"  @click="$wire.set( 'filters.non_demominational', ! $wire.filters.non_demominational )" label="Non Denominational" icon="heroicon-o-user">
                <img class="max-w-9" src="{{ asset('assets/image_icons/Search-Schools-NonDenominational.png') }}" />
            </x-app.search.boolean-filter>

            <x-app.search.filter label="Curriculum" image="Search-Schools-13-Curriculum.png" :class="empty( $filters['curricula'] ) ? 'border-transparent' : 'border-gray-200'">
                <x-input.outline wire:model.live.debounce.200ms="search_curriculums_filters" placeholder="Search curricula" />
                @foreach($curricula as $curriculum)
                    <x-select.option wire:click="toggleFilter( 'curricula', {{ $curriculum->id }}, '{{ $curriculum->name }}' )" :active="array_key_exists( $curriculum->id, $filters['curricula'])">
                        {{ $curriculum->name }}
                    </x-select.option>
                @endforeach
            </x-app.search.filter>

    </div>

    @if( $display_map )
        <livewire:search.map :markers="$markers" key="search_map_school" />
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-8 mb-8 mt-4 px-5 4xl:px-0" wire:loading.class="opacity-25">
        @foreach($campuses as $campus)
            <livewire:search.school-card :key="'campus_' . $campus->id" :campus="$campus" />
        @endforeach
    </div>

    @if($campuses->isEmpty())
        <div class="flex flex-col pb-20 text-gray-600 gap-20 p-5 items-center">
            <h3 class="text-6xl text-center">
                Unable to find <span class="text-primary">your dream school?</span> Get in touch!
            </h3>
            <x-buttons.primary elem_type="link" href="{{ route('contact') }}" size="lg">Contact Us</x-buttons.primary>
        </div>
    @endif

</div>
