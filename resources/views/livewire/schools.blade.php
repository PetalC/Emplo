<div class="max-w-8xl mx-auto flex flex-col text-secondary">
    {{-- section 1: banner --}}
    <div class="relative flex flex-col items-center lg:mt-0 mt-12 overflow-hidden">
        <div class="h-24 mt-12">
            <x-app.logo.logo class="w-auto h-full" />
        </div>
        <div class="lg:w-full w-[200%]">
            <img src="{{ asset('assets/app/Teacher-Animation.gif') }}" class="w-full" />
        </div>
    </div>

    {{-- section 2 --}}
    <div class="flex flex-col items-center gap-20 px-5 lg:px-0 -mt-10">
        <x-text.heading variant="h1" class="text-center relative z-10"><span class="text-primary">Staff</span> are your greatest asset.</x-text.heading>

        <div class="flex flex-col items-center gap-10">
            <div class="flex flex-col text-center gap-2">
                <p>Employo is a software solution designed to assist schools in attracting top-tier staff, fortifying safety</p>
                <p>protocols, and making intelligent hiring decisions. By seamlessly integrating advanced recruitment tools,</p>
                <p>robust safeguarding features, and insightful analytics, we enable educational institutions to build resilient</p>
                <p>teams, Join us on the journey to elevate your school's potential, where technology becomes a catalyst for</p>
                <p>attracting, safeguarding, and wisely selecting the individuals who contribute to a thriving educational</p>
                <p>community and shape the leaders of tomorrow.</p>
            </div>

            <x-buttons.primary elem_type="link" href="{{ route( 'auth', [ '#register', 'school' => 1  ] ) }}" size="lg" class="lg:w-fit w-full">Start hiring now</x-buttons.primary>

            <div class="flex flex-col text-center gap-2">
                <p>Employo is your low-cost, high-value solution. Sing up and shoose from four</p>
                <p>packages. All schools receive a one-month free trial which includes our full suite of</p>
                <p>features and commences only when you post your first job!</p>
            </div>

            <div class="flex lg:flex-row flex-col items-center gap-4 w-full lg:mb-0 mb-10 lg:justify-center" x-data="{isMobile: window.innerWidth <= 768}">
                <x-buttons.secondary size="lg" class="border-primary text-primary py-3 lg:w-fit w-full">Generate a quote</x-buttons.secondary>
                <x-buttons.secondary size="lg" class="border-primary text-primary py-3 lg:w-fit w-full">Book a demo</x-buttons.secondary>
                <x-buttons.secondary size="lg" class="border-primary text-primary py-3 lg:w-fit w-full">Refer a School</x-buttons.secondary>
            </div>
        </div>
    </div>

    {{-- section 2: shortlisted candidate --}}
    <div class="flex flex-col gap-20 mt-20">
        <x-app.school.shortlisted-candidate-card />

        <div class="flex lg:flex-row flex-col lg:px-0 px-5 lg:gap-0 gap-10 overflow-hidden">
            <div class="lg:w-1/2 w-full flex flex-col gap-20">
                <x-text.heading variant="h5" class="text-center lg:text-left px-20"><span class="text-primary">Self-Managed</span> Software</x-text.heading>

                <div class="flex flex-col gap-10 ml-10">
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

            <div class="relative lg:w-1/2 w-full">
                <div class="relative lg:ml-24 lg:mr-10 ml-[160px] z-10 lg:w-fit w-full">
                    <img src="{{ asset('assets/app/schools-screenshot-1.png') }}" />

                    <img src="{{ asset('assets/app/schools-screenshot-ellipse-1.png') }}" class="absolute w-60 h-60 top-1/2 left-10 -translate-y-1/2 -translate-x-1/2" />
                </div>

                <div class="absolute w-24 h-[calc(50%_+_80px)] top-0 left-0 -mt-20 lg:border-l border-b border-app/50">
                </div>
            </div>
        </div>
    </div>

    {{-- section 3 --}}
    <div class="flex flex-col gap-20 mb-32">
        <x-text.heading variant="h1" class="text-center">Powerful recruiting <span class="text-primary">for schools</span></x-text.heading>

        <div class="flex flex-col items-center gap-1">
            <p>Employo tools integrate to save you time while increasing the visibility of your</p>
            <p>school and adding greater consistency to your hiring.</p>
        </div>

        <x-app.public.feature-showcase />

        <div class="flex flex-col items-center gap-20 mt-4">
            <span class="text-2xl"><b>Start finding</b> staff today</span>

{{--            <div class="flex flex-col items-center gap-1 lg:px-96">--}}
{{--                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a gallery of  type and scrambled it to make a type specimen book.</p>--}}
{{--            </div>--}}

            <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="lg" class="lg:w-fit w-full">Start hiring now</x-buttons.primary>
        </div>

    </div>
</div>
