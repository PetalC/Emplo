<div class="max-w-8xl mx-auto flex flex-col text-secondary"
     x-data="{ at_top: true }"
     @scroll.window="at_top = (window.pageYOffset > 0 ? false : true)"
>

    <div class="relative lg:flex hidden justify-between lg:pt-12 px-5 3xl:px-0">
        <div class="h-20 flex items-center ml-[80px]">
            <x-app.logo.logo class="max-w-[160px]" />
        </div>

        <x-text.heading variant="h1" class="text-center mr-[80px]">
            <span class="text-primary">Job Hunting</span> made easy.
        </x-text.heading>
    </div>

    <div class="p-10 lg:mx-5 3xl:mx-0 fixed top-0 left-0 lg:static w-full lg:w-auto lg:mt-10 z-10 bg-white rounded-xl shadow-lg border border-gray-300">
        <div class="flex lg:items-center lg:justify-between gap-4 w-full lg:flex-row flex-col">
            <div class="lg:flex items-center justify-between gap-10 hidden">
                <x-text.heading variant="h5" class="whitespace-nowrap font-light">Find <span class="text-primary">your opportunity</span></x-text.heading>
                <img src="{{ asset('assets/app/forward.png') }}" class="min-w-20" />
            </div>

            <div class="flex lg:hidden justify-start w-full max-w-44 transition-all duration-800" x-bind:class="at_top ? 'max-w-[160px]' : 'max-w-[100px]' ">
                <x-app.logo.logo class="max-w-[160px]" />
            </div>
            {{-- search box --}}
            <div class="flex flex-col items-center xl:flex-row justify-around w-full gap-4">

                <x-app.dashboard.search class="col-span-1 lg:col-span-4 max-w-[600px]" id="search" wire:model.live.debounce.200ms="search_value" placeholder="Search job roles, schools or suburbs" />

                <div x-data="{ toggle: $wire.entangle('show_schools').live }"  @click="toggle = !toggle" class="flex gap-4 items-center col-span-1 lg:col-span-2 justify-center lg:justify-start">
                    <span :class="toggle ? '' : 'text-primary'" class="text-2xl">Jobs</span>
                    <x-input.toggle id="toggle-board" name="toggle-board" wire:model="show_schools" />
                    <span :class="!toggle ? '' : 'text-primary'" class="text-2xl">Schools</span>
                </div>

                {{-- <x-buttons.primary :shadow="false" fullWidth class="lg:text-base col-span-2 lg:col-span-2 justify-self-end w-full lg:order-3">Search</x-buttons.primary> --}}
            </div>

        </div>
    </div>

    <div class="mt-[300px] lg:mt-12"></div>

    <div wire:loading.class="opacity-50" wire:target="show_schools">
        @if( $show_schools )
            <livewire:search.school-board wire:model="search_value" />
        @else
            <livewire:search.job-board wire:model="search_value" />
        @endif
    </div>


    {{-- create your profile --}}
    <div class="flex flex-col pb-20 text-gray-600 gap-20 p-5">

        <x-text.heading variant="h1" class="text-center">
            Create <span class="text-primary">your profile</span>
        </x-text.heading>

{{--        This doesn't need to be a livewire component. For some reason this kills livewire when its a component--}}
{{--        <livewire:dashboard.shortlisted-candidate-card />--}}
        <div class="flex lg:flex-row flex-col justify-between lg:gap-0 gap-20 p-10 rounded-lg bg-gradient-to-r from-[#CECDCB] to-[#C9CDD5] text-gray-600">
            <div class="lg:w-[300px] lg:h-[300px] w-full rounded-md overflow-hidden">
                <img src="{{ asset('assets/app/anne.png') }}" class="lg:w-fit w-full fit-content" />
            </div>

            <div class="lg:w-1/2 flex lg:flex-col flex-col my-8 justify-between gap-5 lg:gap-0 w-[1/3]">
                <h5 class="text-5xl font-medium">Anne Sullivan</h5>

                <span class="text-2xl">English Teacher</span>

                <p class="text-2xl mr-10">
                    I've been working as an English teacher for 3 years now and am looking to continue my journey at another great school in the Greater Sydney area.
                </p>

                <div class="w-[50px] h-[3px] bg-gray-500"></div>
            </div>

            <div class="lg:w-1/4 flex flex-col justify-between w-full mb-8 lg:gap-0 gap-5">
                <div class="lg:flex hidden justify-end">
                    <x-badge variant="success"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2" />Shortlisted</x-badge>
                </div>

                <div class="flex flex-col gap-4">
                    <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Identify Check</span>
                    <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Working with Children Check</span>
                    <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Reference Check</span>
                </div>
                <div class="lg:hidden flex justify-center">
                    <x-badge variant="success"><x-icon name="heroicon-m-check" class="w-6 h-6 mr-2" />Shortlisted</x-badge>
                </div>
            </div>
        </div>

        <div class="flex flex-col text-center gap-2">
            <p>This will be the smartest 5 minutes you ever spend. Complete the profile that will act like a universal application as</p>
            <p>our technology will help you automate your search. Hunt for teaching and non-teaching jobs, search for schools</p>
            <p>and access employment information like never before. Free for candidates.</p>
        </div>

        <div class="lg:relative lg:h-14">
            <div class="absolute top-1/2 w-full h-[1px] bg-gray-300 lg:block hidden"></div>
            <div class="lg:absolute lg:left-1/2 lg:-translate-x-[95px] flex items-center lg:gap-20 gap-5 lg:flex-row flex-col">
                <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="lg">Create your profile now</x-buttons.primary>
{{--                <x-buttons.secondary size="lg" class="cursor-not-allowed"> <x-icon name="zondicon-envelope" class="w-4 h-4 mr-2 text-gray-300" />  Email me a reminder</x-buttons.secondary>--}}
            </div>
        </div>
    </div>

    @if( ! $show_schools )
        <div class="flex flex-col gap-10 text-gray-600 pb-20">
            <livewire:application.school.search-slider />
        </div>
    @endif

</div>
