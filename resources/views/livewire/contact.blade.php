<div class="max-w-8xl mx-auto flex flex-col text-secondary">
    <div class="flex flex-col divide-y divide-y-app lg:mt-0 mt-12">
        {{-- section 1 --}}
        <div class="flex flex-col gap-20 items-center w-full pb-20">
            <div class="h-24 mt-12">
                <x-app.logo.logo class="w-auto h-full" />
            </div>

            <div class="flex flex-col lg:gap-20 gap-5 items-center w-full lg:px-40 px-10">
                <x-text.heading variant="h1"><span class="text-primary">Reach out</span> to us.</x-text.heading>

                <div class="flex lg:flex-row flex-col w-full lg:gap-0 gap-10">
                    <div class="flex lg:w-2/5 lg:mr-20 items-center">
                        <img src="{{ asset('assets/app/contact-banner.png') }}" class="w-full" />
                    </div>

                    <div class="lg:w-3/5 ">

                        @if( $is_sent )
                            <x-notifications.success class="col-span-2">Your message has been sent successfully.</x-notifications.success>
                        @endif
                            <div class="grid lg:grid-cols-2 grid-cols-1 gap-x-4 gap-y-10" wire:loading.class="opacity-50">
                                <x-input.outline wire:model.blur="name" id="full-name" name="full-name" label="Full name" placeholder="Your full name" />
                                <x-input.outline wire:model.blur="phone" id="phone" name="phone" label="Phone number" placeholder="Your phone number" />
                                <x-input.outline wire:model.blur="email" id="email" name="email" label="Email address" placeholder="Your email address" />
                                <x-input.outline wire:model.blur="school" id="school-name" name="school-name" label="If reaching out from a school" placeholder="Your school name" />
                                <div class="lg:col-span-2">
                                    <x-input.textarea
                                        wire:model.blur="message"
                                        id="message"
                                        name="message"
                                        label="Message"
                                        placeholder="Let us know how we can help..."
                                        rows="10"
                                    />
                                </div>
                                <div class="lg:col-span-2 flex lg:flex-row flex-col lg:items-center lg:justify-between lg:gap-0 gap-10">
                                    {{--                            <x-input.checkbox id="join-newsletter" label="Join our newsletter" />--}}
                                    <x-button.primary wire:click="submitContactRequest" size="lg" class="lg:w-fit w-full">Send enquiry</x-button.primary>
                                </div>
                            </div>

                    </div>


                </div>
            </div>
        </div>

        {{-- section 2 --}}
        <div class="flex flex-col items-center gap-20 py-20">
            <x-text.heading variant="h1"><span class="text-primary">What can Employo</span> do for you?</x-text.heading>

            <div class="flex flex-col items-center gap-1">
                <p><b>Candidates</b> - hunt for teaching and non-teaching jobs. Search for schools. Access employment</p>
                <p>information like never before. Apply for jobs with ease.</p>

                <p class="mt-4"><b>Schools</b> - Attract teachers and non-teaching candidates 365 days per year. Be amazed as AI</p>
                <p>technology notifies matching candidates when a vacancy arises. Broaden your advertising reach at</p>
                <p>the click of a button. Mitigate the risk of a prolonged vacancy. Easily collaborate with panel members.</p>
                <p>Automate safeguarding to guide decision-making.</p>
            </div>

            <div class="flex lg:flex-row flex-col items-center gap-8 lg:w-fit w-full px-5">
                <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="lg" class="lg:w-fit w-full">Register your school</x-buttons.primary>
                <x-buttons.secondary elem_type="link" href="{{ route( 'auth' ) }}" size="lg" class="lg:w-fit w-full">Signup as a job seeker</x-buttons.secondary>
            </div>
        </div>

        {{-- section 3 --}}
        <div class="flex flex-col gap-20 py-20">
            <div class="grid lg:grid-cols-2 grid-cols-1 px-20 lg:gap-0 gap-5">
                <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-0 gap-5">
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

                    <div class="flex flex-col gap-4">
                        <x-icon name="heroicon-o-envelope" class="w-5 h-5" />

                        <div class="flex flex-col gap-2">
                            <b>Email</b>

                            <div class="flex flex-col gap-1">
                                <span>hello@employo.com.au</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <x-icon name="heroicon-o-map-pin" class="w-5 h-5" />

                    <div class="flex flex-col gap-2">
                        <b>Locations</b>

                        <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-4 gap-5">
                            <div class="flex flex-col gap-1">
                                <span>Brisbane</span>
                                <span>260 Queen Street, Brisbane, Queensland 4000</span>
                                <span>Australia</span>
{{--                                <a class="underline cursor-pointer">View in maps</a>--}}
                            </div>

                            <div class="flex flex-col gap-1">
                                <span>Melbourne</span>
                                <span>276 Flinders Street, Melbourne, Victoria 3000</span>
                                <span>Australia</span>
{{--                                <a class="underline cursor-pointer">View in maps</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:flex flex-col items-center gap-20 hidden">
                <x-text.heading variant="h1">Our <span class="text-primary">partners.</span></x-text.heading>

                <div class="flex flex-col items-center gap-1">
                    <p>These are some of the brands which work with us and trust us to provide reliable</p>
                    <p>and high quality recruitment services.</p>
                </div>

                <div class="flex justify-center">
                    <img src="{{ asset('assets/app/partners.png') }}" class="w-full" />
                </div>
            </div>
        </div>
    </div>
</div>
