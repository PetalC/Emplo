<div class="flex flex-col px-5 lg:px-0">
    <div class="flex flex-col" x-data="{ activeImage:'{{ asset('assets/app/Screen-1.png') }}', activeIndex:1}">
        {{-- circles --}}
        <div class="lg:flex hidden items-center justify-between gap-20 w-[1200px] mx-auto">
            <div x-bind:class="{'drop-shadow-app' : activeIndex == 1}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-1.png') }}', activeIndex=1">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-dashboard.png') }}" class="w-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 1, 'text-app' : activeIndex != 1}" class="mt-5 text-lg">Dashboard</span>
            </div>

            <div x-bind:class="{'drop-shadow-app' : activeIndex == 2}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-2.png') }}', activeIndex=2">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-employer-profile.png') }}" class="w-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 2, 'text-app' : activeIndex != 2}" class="mt-5 text-lg">Employer Profile</span>
            </div>

            <div x-bind:class="{'drop-shadow-app' : activeIndex == 3}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-3.png') }}', activeIndex=3">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-staffroom.png') }}" class="w-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 3, 'text-app' : activeIndex != 3}" class="mt-5 text-lg">Staffroom</span>
            </div>

            <div x-bind:class="{'drop-shadow-app' : activeIndex == 4}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-4.png') }}', activeIndex=4">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-job-center.png') }}" class="w-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 4, 'text-app' : activeIndex != 4}" class="mt-5 text-lg">Job Center</span>
            </div>

            <div x-bind:class="{'drop-shadow-app' : activeIndex == 5}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-5.png') }}', activeIndex=5">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-applicant-tracking.png') }}" class="w-20 h-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 5, 'text-app' : activeIndex != 5}" class="mt-5 text-lg text-nowrap">Applicant Tracking</span>
            </div>

            <div x-bind:class="{'drop-shadow-app' : activeIndex == 6}" class="flex flex-col items-center" x-on:click="activeImage = '{{ asset('assets/app/Screen-6.png') }}', activeIndex=6">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-36 h-36">
                    <img src="{{ asset('assets/app/schools-circle-resource-library.png') }}" class="w-24" />
                </div>
                <span x-bind:class="{'text-primary' : activeIndex == 6, 'text-app' : activeIndex != 6}" class="mt-5 text-lg">Resource Library</span>
            </div>
        </div>

        <div class="lg:hidden flex items-center justify-between gap-20 w-full px-24" x-data="{ index: 0 }">
            <div class = "rounded-md bg-gray-300 flex items-center justify-center cursor-pointer" x-on:click="index = (index + 5) % 6"><x-icon name="heroicon-s-chevron-left" class="w-10 h-10 text-white" /></div>

            <div x-show="index == 0" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white drop-shadow-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-dashboard.png') }}" class="w-24" />
                </div>
                <span class="text-primary mt-5 text-lg">Dashboard</span>
            </div>

            <div x-show="index == 1" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-employer-profile.png') }}" class="w-24" />
                </div>
                <span class="mt-5 text-lg">Employer Profile</span>
            </div>

            <div x-show="index == 2" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-staffroom.png') }}" class="w-24" />
                </div>
                <span class="mt-5 text-lg">Staffroom</span>
            </div>

            <div x-show="index == 3" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-job-center.png') }}" class="w-24" />
                </div>
                <span class="mt-5 text-lg">Job Center</span>
            </div>

            <div x-show="index == 4" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-applicant-tracking.png') }}" class="w-20 h-24" />
                </div>
                <span class="mt-5 text-lg">Applicant Tracking</span>
            </div>

            <div x-show="index == 5" class="flex flex-col items-center w-full">
                <div class="flex items-center justify-center rounded-full bg-white border border-app w-48 h-48">
                    <img src="{{ asset('assets/app/schools-circle-resource-library.png') }}" class="w-24" />
                </div>
                <span class="mt-5 text-lg">Resource Library</span>
            </div>

            <div class = "rounded-md bg-gray-300 flex items-center justify-center cursor-pointer" x-on:click="index = (index + 1) % 6"><x-icon name="heroicon-s-chevron-right" class="w-10 h-10 text-white" /></div>
        </div>

        <div class="lg:flex hidden flex-col h-60 mx-24">
            <div class="flex items-end h-1/2">
                <div x-bind:class="{'ml-40' : activeIndex == 1, 'ml-[400px]' : activeIndex == 2, 'ml-[620px]' : activeIndex == 3, 'ml-[840px]' : activeIndex == 4, 'ml-[1060px]' : activeIndex == 5, 'ml-[1280px]' : activeIndex == 6}" class="flex w-full h-4/5 border-l border-app/50"></div>
            </div>

            <div class="grid grid-cols-2 h-1/2">
                <div>
                    <div x-show="activeIndex <= 3" x-bind:class="{'ml-40' : activeIndex == 1, 'ml-[400px]' : activeIndex == 2, 'ml-[620px]' : activeIndex == 3}" class="border-t border-r border-app/50 h-full">
                    </div>
                </div>
                <div>
                    <div x-show="activeIndex >= 4" x-bind:class="{'mr-[570px]' : activeIndex == 4, 'mr-[350px]' : activeIndex == 5, 'mr-[130px]' : activeIndex == 6}" class="border-t border-l border-app/50 h-full">
                    </div>
                </div>
            </div>
        </div>

        {{-- screenshot --}}
        <div class="relative max-w-3xl mx-auto lg:mt-0 mt-20 overflow-hidden">
            <img x-bind:src="activeImage" class="ml-[160px] lg:ml-0" />
        </div>
    </div>

</div>
