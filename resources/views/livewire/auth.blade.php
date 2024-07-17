@php use Illuminate\Support\Facades\Request; @endphp
<div class="max-w-8xl mx-auto flex flex-col text-secondary">

    <div class="flex flex-col items-center gap-20">
        <div class="h-24 mt-12">
            <x-app.logo.logo class="w-auto h-full" />
        </div>

        @if( Request::has( 'ref' ) )

            @switch( Request::get( 'ref' ) )
                @case( 'bookmark' )
                    <x-notifications.notice class="w-full">
                        Please login or register to save a job.
                    </x-notifications.notice>
                    @break
            @endswitch

        @endif

        <div class="flex flex-col w-full items-center">
            {{-- section 1: Login --}}
            <div class="grid grid-cols-4 gap-10 w-full">
                <x-text.heading variant="h1" class="text-center col-span-12 inline sm:hidden">
                    How can we <span class="text-primary">help you?</span>
                </x-text.heading>
                <div class="col-span-12 md:col-span-1">
                    <img src="{{ asset('assets/app/signin-animation.gif') }}" class="w-full"/>
                </div>

                <div class="col-span-12 md:col-span-2">
                    <div class="flex flex-col gap-14">
                        <x-text.heading variant="h1" class="hidden sm:inline text-center">
                            How can we <span class="text-primary">help you?</span>
                        </x-text.heading>

                        <livewire:auth.login/>
                    </div>
                </div>
            </div>

            <hr class="w-full border-t border-gray-200 my-20" id="register"/>

            {{-- section 2: Role --}}

            <div x-data="{ toggle: $wire.entangle('role').live }" @click="toggle = ! toggle" class="flex gap-4 items-center justify-center">
                <span class="font-bold" :class="toggle ? '' : 'text-primary'">I'm a job seeker</span>
                <x-input.toggle id="role" name="role" x-model="toggle"/>
                <span class="font-bold" :class="!toggle ? '' : 'text-primary'">I'm a school</span>
            </div>

            {{-- section 2: Register --}}
            @if(!$role)
                <livewire:auth.teacher.register/>
            @else
                <livewire:auth.school.register/>
            @endif

            {{-- section 3: Contact --}}
            <div class="grid grid-cols-1 md:grid-cols-2 p-10 sm:p-20">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="flex flex-col gap-4 mt-5 md:mt-0">
                        <x-icon name="heroicon-o-phone" class="w-5 h-5"/>

                        <div class="flex flex-col gap-2">
                            <b>Phone number</b>

                            <div class="flex flex-col gap-1">
                                <span>Brisbane +61 7 3130 0846</span>
                                <span>Melbourne +61 3 8007 2420</span>
                                <span>Sydney +61 2 9000 1438</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 mt-5 md:mt-0">
                        <x-icon name="heroicon-o-envelope" class="w-5 h-5"/>

                        <div class="flex flex-col gap-2">
                            <b>Email</b>

                            <div class="flex flex-col gap-1">
                                <span>hello@employo.com.au</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mt-5 md:mt-0">
                    <x-icon name="heroicon-o-map-pin" class="w-5 h-5"/>

                    <div class="flex flex-col gap-2">
                        <b>Locations</b>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
        </div>
    </div>
</div>
