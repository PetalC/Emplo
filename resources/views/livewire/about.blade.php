<div class="max-w-8xl mx-auto flex flex-col text-secondary">
    {{-- section 1 --}}
    <div class="flex flex-col divide-y divide-y-b">
        <div class="flex flex-col items-center mb-20">
            <div class="h-24 mt-12">
                <x-app.logo.logo class="w-auto h-full" />
            </div>

            <div class="mt-20 flex flex-col items-center gap-20 text-center xl:text-left">
                <x-text.heading variant="h1">We exist to connect <span class="text-primary">quality candidates and schools</span></x-text.heading>

                <div class="flex flex-col text-center gap-1">
                    <p>High-quality education starts with high-quality staff. Employo exists to break down barriers, connecting educational institutions with great staff,</p>
                    <p>and candidates with the jobs and schools that matter to them - <b>365 days a year</b>. Developed for schools and candidates alike, Employo is </p>
                    <p>enhancing the education recruitment landsacpe while saving you time and money - so you can do more, with less. With our web-based platform,</p>
                    <p>schools can proactively showcase their employee value proposition and widen their advertising reach, allowing you to access an otherwise</p>
                    <p>untapped audience of engaged educators who want to work at your school. For teachers, support staff and leaders, our technology innovates the</p>
                    <p>search experience, while providing valuable insights into employment offerings, work conditions, career progression and more. Simplify your</p>
                    <p>application while standing out from the crowd thanks to powerful automation.</p>
                    <p class="mt-4">Join the many schools and candidates who've already found success with employo.</p>
                </div>

                <div class="flex items-center flex-col sm:flex-row gap-8">
                    <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="lg">Register your school</x-buttons.primary>
                    <x-buttons.dark elem_type="link" href="{{ route( 'auth' ) }}" size="lg">Signup as a job seeker</x-buttons.dark>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 p-10 md:p-20">
            <div class="grid gird-cols-1 mt-5 md:mt-0 md:grid-cols-2">
                <div class="flex flex-col gap-4">
                    <x-icon name="heroicon-o-phone" class="w-5 h-5" />

                    <div class="flex flex-col gap-2">
                        <b>Phone number</b>

                        <div class="flex flex-col gap-1">
                            <span>Brisbane +61 7 3130 0846</span>
                            <span>Melbourne +61 3 8007 2420</span>
                            <span>Sydney +61 2 9000 1438</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mt-10 md:mt-0">
                    <x-icon name="heroicon-o-envelope" class="w-5 h-5" />

                    <div class="flex flex-col gap-2">
                        <b>Email</b>

                        <div class="flex flex-col gap-1">
                            <span>hello@employo.com.au</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4 mt-10 md:mt-0">
                <x-icon name="heroicon-o-map-pin" class="w-5 h-5" />

                <div class="flex flex-col gap-2">
                    <b>Locations</b>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <span>Brisbane</span>
                            <span>260 Queen Street, Brisbane, Queensland 4000</span>
                            <span>Australia</span>
{{--                            <a class="underline cursor-pointer">View in maps</a>--}}
                        </div>

                        <div class="flex flex-col gap-1">
                            <span>Melbourne</span>
                            <span>276 Flinders Street, Melbourne, Victoria 3000</span>
                            <span>Australia</span>
{{--                            <a class="underline cursor-pointer">View in maps</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- section 2 --}}
    <div class="flex flex-col gap-20 mt-20">
        <x-app.school.shortlisted-candidate-card />

        <div class="flex flex-row justify-between flex-wrap gap-20">
            <div class="flex flex-col gap-20 w-full xl:w-auto">
                <x-text.heading variant="h5" class="text-center xl:text-left"><span class="text-primary">Self-Managed</span> Software</x-text.heading>

                <div class="flex flex-col gap-10 m-auto xl:ml-10">
                    <div class="flex items-start">
                        <x-icon name="heroicon-s-check-circle" class="w-8 h-8 text-primary" />

                        <div class="flex flex-col gap-2 ml-6">
                            <span class="font-bold text-2xl">Safeguard</span>

                            <div class="flex flex-col text-sm gap-1">
                                <p>Safeguard your current and future recruitment. Leverage AI, automations</p>
                                <p>and integrations with licensing and child protection authorities</p>
                                <p>Effortlessly generate reports to inform planning and compliance.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <x-icon name="heroicon-s-check-circle" class="w-8 h-8 text-primary" />

                        <div class="flex flex-col gap-2 ml-6">
                            <span class="font-bold text-2xl">Enhance</span>

                            <div class="flex flex-col text-sm gap-1">
                                <p>Enhance your recruitment. Access an otherwise untapped source of</p>
                                <p>teachers, non-teachers and leaders. Let automated compliance and</p>
                                <p>collaboration guide your decision-making.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <x-icon name="heroicon-s-check-circle" class="w-8 h-8 text-primary" />

                        <div class="flex flex-col gap-2 ml-6">
                            <span class="font-bold text-2xl">Attract</span>

                            <div class="flex flex-col text-sm gap-1">
                                <p>Showcase your school. Attract followers 365 days per year. Broaden your</p>
                                <p>advertising reach at the click of a button. Mitigate the risk of re-advertising.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative w-1/2 flex w-full xl:w-1/2 flex">
                <div class="relative ml-0 mr-0 md:ml-24 md:mr-10 z-10">
                    <img src="{{ asset('assets/app/schools-screenshot-1.png') }}" class="w-full h-full"/>

                    <img src="{{ asset('assets/app/schools-screenshot-ellipse-1.png') }}" class="absolute w-40 h-40 sm:w-60 sm:h-60 top-1/2 left-10 -translate-y-1/2 -translate-x-1/2" />
                </div>

                <div class="absolute w-24 h-[calc(50%_+_80px)] top-0 left-0 -mt-20 border-l border-b border-app/50">
                </div>
            </div>
        </div>
    </div>

    {{-- section 3 --}}
    <div class="flex flex-col gap-20 mb-20">
        <x-text.heading variant="h1" class="text-center">Powerful recruiting <span class="text-primary">for schools</span></x-text.heading>

        <div class="flex flex-col items-center gap-1 text-center md:text-center">
            <p>Employo tools integrate to save you time while increasing the visibility of your</p>
            <p>school and adding greater consistency to your hiring.</p>
        </div>

        <x-app.public.feature-showcase />

        <div class="flex flex-col items-center gap-20 mt-4">
            <span class="text-2xl"><b>Start finding</b> staff today</span>

            {{--                <div class="flex flex-col items-center gap-1">--}}
            {{--                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the</p>--}}
            {{--                    <p>industry's standard dummy text ever since the 1500s, when an unknown printer took a gallery of  type and</p>--}}
            {{--                    <p>scrambled it to make a type specimen book.</p>--}}
            {{--                </div>--}}

            <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="lg">Start hiring now</x-buttons.primary>
        </div>

    </div>
</div>
