<div>

{{--    It was easier to split the vide into 2 components, One for mobile one for larger devices.--}}
    <div class="relative md:hidden max-w-full overflow-hidden">
        <div class="h-24 mt-[calc(100vw/3)] absolute w-full z-10">
            <x-app.logo.logo class="mx-auto w-1/2 h-auto" />
        </div>
        <video class="min-w-[calc(100vw*2)] -translate-x-[25%] h-auto" loop autoplay>
            <source src="{{ asset('assets/app/Employo-Candidates.mp4') }}" type="video/mp4">
        </video>
    </div>

    <div class="relative hidden md:block max-w-[1600px] mx-auto">
        <div class="h-24 mt-[calc(100vw/6)] 2xl:mt-64 absolute w-full">
            <x-app.logo.logo class="lg:w-auto lg:h-full lg:max-w-full mx-auto max-w-44 h-auto" />
        </div>
        <video class="w-full h-auto" loop autoplay>
            <source src="{{ asset('assets/app/Employo-Candidates.mp4') }}" type="video/mp4">
        </video>
    </div>

    <div class="max-w-8xl mx-auto flex flex-col text-secondary relative">
        {{-- banner --}}


        {{-- job board --}}
        <div class="flex flex-col gap-12">
            <x-text.heading variant="h1" class="text-center">
                <span class="text-primary">Job Hunting</span> made easy.
            </x-text.heading>

            <div class="flex flex-col gap-5 mb-5 px-4 3xl:px-0">
{{--                @foreach($jobs as $job)--}}
{{--                    <livewire:search.job-card :key="'job_' . $job->id" :job="$job" />--}}
{{--                @endforeach--}}
                {{--            <div class="px-5">--}}
                {{--                {{ $jobs->links(data: ['scrollTo' => false]) }}--}}
                {{--            </div>--}}
            </div>
        </div>

        <div class="flex flex-col pb-20 text-gray-600">
            <div class="flex flex-col text-center gap-2 px-6 3xl:px-0">
                <p>Employo enables educators to access school employment information, follow the schools you want to</p>
                <p>work in and apply for jobs all in one place. You will als save time job-hunting and improve your</p>
                <p>employment pursuits with help from our tools and team</p>
            </div>

            <div class="grid lg:grid-cols-4 grid-cols-1 mt-16 gap-6 xl:gap-0 lg:w-[960px] mx-auto">
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center rounded-full border border-gray-300 w-[180px] h-[180px]">
                        <img src="{{ asset('assets/app/search.png') }}" class="w-20 h-20 object-contain" />
                    </div>

                    <span class="mt-4 text-xl">Search for</span>
                    <span class="text-primary text-xl">jobs</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center rounded-full border border-gray-300 w-[180px] h-[180px]">
                        <img src="{{ asset('assets/app/school.png') }}" class="w-20 h-20 object-contain" />
                    </div>

                    <span class="mt-4 text-xl">Search for</span>
                    <span class="text-primary text-xl">schools</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center rounded-full border border-gray-300 w-[180px] h-[180px]">
                        <img src="{{ asset('assets/app/document.png') }}" class="w-20 h-20 object-contain" />
                    </div>

                    <span class="mt-4 text-xl">Follow</span>
                    <span class="text-primary text-xl">schools</span>
                </div>

                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center rounded-full border border-gray-300 w-[180px] h-[180px]">
                        <img src="{{ asset('assets/app/apply-now.png') }}" class="w-20 h-20 object-contain" />
                    </div>

                    <span class="mt-4 text-xl">Apply</span>
                    <span class="text-primary text-xl">for jobs</span>
                </div>
            </div>
        </div>

        {{-- create your profile --}}
        <div class="flex flex-col lg:pb-20 pb-5 text-gray-600 gap-20 px-5">
            <h3 class="text-6xl text-center">
                Create <span class="text-primary">your profile</span>
            </h3>

{{--            <livewire:dashboard.shortlisted-candidate-card />--}}

            <div class="flex flex-col text-center gap-2">
                <p>This will be the smartest 5 minutes you ever spend. Complete the profile that will act like a universal application as</p>
                <p>our technology will help you automate your search. Hunt for teaching and non-teaching jobs, search for schools</p>
                <p>and access employment information like never before. Free for candidates.</p>
            </div>

            <div class="relative lg:h-14">
                <div class="lg:absolute top-1/2 w-full h-[1px] bg-gray-300 lg:block hidden"></div>
                <div class="lg:absolute lg:left-1/2 lg:-translate-x-[95px] flex lg:flex-row flex-col items-center lg:gap-20 gap-5">
                    <x-buttons.primary href="{{ route( 'auth', '#register' ) }}" elem_type="link" size="lg">Create your profile now</x-buttons.primary>
                    <x-buttons.secondary size="lg" class="cursor-not-allowed">
                        <x-heroicon-o-envelope class="w-4 h-4 mr-2 text-gray-300 cursor-not-allowed" />  Email me a reminder
                        {{--                    <x-icon name="zondicon-envelope" class="w-4 h-4 mr-2 text-gray-300" />  Email me a reminder--}}
                    </x-buttons.secondary>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-10 text-gray-600 pb-20 lg:mt-0 mt-10">
            <livewire:application.school.search-slider id="search_slider_candidates" :key="'search_slider_candidates'" />
        </div>

        {{--    Hiding this section for now, its a new feature and unnecessary for demo--}}
        {{--    <x-slot:slot_bottom>--}}
        {{--        @auth--}}
        {{--        <div class="sticky w-full left-0 bottom-0 p-10 bg-white drop-shadow z-10">--}}
        {{--            <div class="flex lg:items-center lg:justify-between gap-4 w-full lg:flex-row flex-col">--}}
        {{--                <div class="lg:flex items-center justify-between gap-10 hidden">--}}
        {{--                    <x-text.heading variant="h5" class="whitespace-nowrap">Find <span class="text-primary">your opportunity</span></x-text.heading>--}}
        {{--                    <img src="{{ asset('assets/app/forward.png') }}" class="min-w-20" />--}}
        {{--                </div>--}}

        {{--                <div class="flex lg:hidden justify-start w-full max-w-44 transition-all duration-800" >--}}
        {{--                    <x-app.logo.logo class="max-w-44" />--}}
        {{--                </div>--}}
        {{--                --}}{{-- search box --}}
        {{--                <div class="grid grid-cols-12 w-full gap-4">--}}

        {{--                    <x-app.dashboard.search class="col-span-4" id="search" wire:model.live.debounce.200ms="search_value" placeholder="Search job roles, schools or suburbs" />--}}

        {{--                    <div x-data="{ toggle: false }" class="flex lg:gap-4 lg:justify-center gap-8 items-center col-span-2 ">--}}
        {{--                        <span :class="toggle ? '' : 'text-primary'" class="text-2xl lg:textbase">Jobs</span>--}}
        {{--                        <x-input.toggle id="toggle-b" name="toggle-b" wire:model.live="toggle" />--}}
        {{--                        <span :class="!toggle ? '' : 'text-primary'" class="text-2xl lg:textbase">Schools</span>--}}
        {{--                    </div>--}}

        {{--                    <x-buttons.primary fullWidth class="lg:text-base col-span-3 justify-self-end w-full">Search</x-buttons.primary>--}}
        {{--                    <x-button.secondary fullWidth class="lg:text-base col-span-3 justify-self-end w-full">Request callback</x-button.secondary>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        @else--}}
        {{--        <div class="sticky w-full left-0 bottom-0 p-10 bg-white drop-shadow z-10">--}}
        {{--            <div class="flex lg:items-center lg:justify-around gap-4 w-full lg:flex-row flex-col">--}}
        {{--                <div class="lg:flex items-center justify-between gap-10 hidden">--}}
        {{--                    <x-text.heading variant="h5" class="whitespace-nowrap">How can <span class="text-primary">we help?</span></x-text.heading>--}}
        {{--                    <img src="{{ asset('assets/app/forward.png') }}" class="min-w-20" />--}}
        {{--                </div>--}}

        {{--                <div class="grid grid-cols-6 gap-4">--}}
        {{--                    <x-buttons.primary fullWidth class="bg-pink lg:text-base col-span-3 lg:col-span-3 justify-self-end w-full">I'm looking for a job</x-buttons.primary>--}}
        {{--                    <x-button.secondary fullWidth class="bg-pink lg:text-base col-span-3 lg:col-span-3 justify-self-end w-full">I'm looking to hire</x-button.secondary>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        @endauth--}}
        {{--    </x-slot:slot_bottom>--}}
    </div>
</div>

