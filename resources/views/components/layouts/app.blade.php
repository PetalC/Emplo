@php
use RalphJSmit\Livewire\Urls\Facades\Url;
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'EMPLO' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/xjv3llh.css">

    {{-- mapbox --}}
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js"></script>

    <!-- Styles -->
    @livewireStyles
    @vite('resources/css/app.css')

    <!-- Scripts -->
    @vite('resources/js/app.js')

    @stack('script')
    @stack('head')
</head>

<body class="font-app flex h-full flex-col bg-white antialiased">
{{-- Toast --}}
<livewire:toasts/>

<div class="flex min-h-full flex-col">
    <header>
        <nav x-cloak>
            <div class="px-4 relative z-50 lg:flex hidden justify-between py-4">
                {{-- left menu --}}
                <div class="flex items-center">
                    <x-app.nav-menu href="{{ route('search') }}" active="{{ Url::current() == 'search' }}">
                        Search
                    </x-app.nav-menu>
                    <x-app.nav-menu href="{{ route('candidates') }}" active="{{ Url::current() == 'candidates' }}">
                        Candidates
                    </x-app.nav-menu>
                    <x-app.nav-menu href="{{ route('schools') }}" active="{{ Url::current() == 'schools' }}">
                        Schools
                    </x-app.nav-menu>
                    <x-app.nav-menu href="{{ route('about') }}" active="{{ Url::current() == 'about' }}">
                        About
                    </x-app.nav-menu>
                    <x-app.nav-menu href="{{ route('contact') }}" active="{{ Url::current() == 'contact' }}">
                        Contact
                    </x-app.nav-menu>
                </div>

                {{-- right menu --}}
                <div class="flex items-center">
                    @if( Auth::check() )
                        @role('School Admin')
                            <x-app.nav-menu
                                href="{{ route('school.dashboard') }}"
                            >
                                My Account
                            </x-app.nav-menu>
                        @endrole
                        @role('Job Seeker')
                            <x-app.nav-menu
                                href="{{ route('profile') }}"
                            >
                                My Account
                            </x-app.nav-menu>
                        @endrole
                    @else
                        <x-app.nav-menu href="{{ route('auth') }}" active="{{ Url::current() == 'auth' }}">
                            Login
                        </x-app.nav-menu>
                    @endif
                </div>
            </div>

            <x-app.navigation.responsive/>

        </nav>
    </header>

            <main class="flex-auto items-center">
                {{ $slot ?? '' }}
            </main>

    <footer class="bg-stone-100 text-gray-700 flex flex-col divide-y divide-gray-300 pl-0 sm:pl-10 lg:pl-0">
        <div class="flex flex-col pl-10 sm:pl-0">
            <div class="max-w-7xl lg:mx-auto flex flex-col gap-10 py-10">
                <h3 class="text-xl">Resources</h3>

                <div class="grid lg:grid-cols-3 grid-cols-1 gap-10 text-sm">
                    <div class="flex flex-col gap-4">
                        <h5 class="font-semibold">Tools</h5>

                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-10">
                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Search jobs</x-app.foot-menu>
                                <x-app.foot-menu>Search schools</x-app.foot-menu>
                                <x-app.foot-menu>Follow schools</x-app.foot-menu>
                            </div>

                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Apply for a job</x-app.foot-menu>
                                <x-app.foot-menu>Speak with recruiter</x-app.foot-menu>
                                <x-app.foot-menu>General enquiry</x-app.foot-menu>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h5 class="font-semibold">Candidates</h5>

                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-10">
                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Career path advice</x-app.foot-menu>
                                <x-app.foot-menu>Resume preparation</x-app.foot-menu>
                                <x-app.foot-menu>Interviewing advice</x-app.foot-menu>
                            </div>

                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Online resources</x-app.foot-menu>
                                <x-app.foot-menu>Government resources</x-app.foot-menu>
                                <x-app.foot-menu>Contact us</x-app.foot-menu>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <h5 class="font-semibold">Schools</h5>

                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-10">
                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Speak with Software Specialists</x-app.foot-menu>
                                <x-app.foot-menu>Job Description templates</x-app.foot-menu>
                                <x-app.foot-menu>Interviewing formats</x-app.foot-menu>
                            </div>

                            <div class="flex flex-col gap-4">
                                <x-app.foot-menu>Legal checks</x-app.foot-menu>
                                <x-app.foot-menu>Contact us</x-app.foot-menu>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col pl-10 sm:pl-0">
            <div class="max-w-7xl mx-auto w-full grid lg:grid-cols-3 grid-cols-1 gap-10 text-sm py-10">
                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Quick links</h5>

                    <div class="flex flex-col gap-4">
                        <x-app.foot-menu>Signin</x-app.foot-menu>
                        <x-app.foot-menu>Signup</x-app.foot-menu>
                        <x-app.foot-menu>About Employo</x-app.foot-menu>
                        <x-app.foot-menu>Contact us</x-app.foot-menu>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Candidates</h5>

                    <div class="flex flex-col gap-4">
                        <x-app.foot-menu>Find your dream school</x-app.foot-menu>
                        <x-app.foot-menu>Register with our recruiters</x-app.foot-menu>
                        <x-app.foot-menu>Terms of Use</x-app.foot-menu>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Schools</h5>

                    <div class="flex flex-col gap-4">
                        <x-app.foot-menu>Find your dream candidates</x-app.foot-menu>
                        <x-app.foot-menu>Pricing & Packages</x-app.foot-menu>
                        <x-app.foot-menu>Terms & Conditions</x-app.foot-menu>
                        <x-app.foot-menu>Policy</x-app.foot-menu>
                    </div>
                </div>
            </div>

            <div class="w-full m-10 sm:m-auto sm:w-auto mb-10 block lg:hidden">
                <img src="{{ asset('assets/app/footer-logo.png') }}" class="mx-auto"/>
                <p class="text-center text-secondary tracking-wide">BUILT FOR EDUCATION</p>
            </div>
        </div>


        <div class="flex ml-32 sm:m-auto flex-col">
            <div class="max-w-7xl w-full mx-auto flex lg:flex-row flex-col-reverse items-center justify-between py-4 text-sm gap-10 lg:gap-0 my-12 lg:my-0">
                <div class="flex lg:flex-row flex-col lg:gap-0 gap-2 items-center justify-center text-gray-700">
                    <p>© {{ date('Y') }} EmployPty Limited</p>
                    <div class="flex">
                        <span class="mx-2 lg:block hidden">•</span>
                        <x-app.foot-menu>Privacy</x-app.foot-menu>
                        <span class="mx-2 ">•</span>
                        <x-app.foot-menu>Terms</x-app.foot-menu>
                        <span class="mx-2 lg:block hidden">•</span>
                        <x-app.foot-menu class="lg:block hidden">Sitemap</x-app.foot-menu>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <x-app.foot-menu class="flex">
                        <x-heroicon-o-arrow-small-up class="w-5 h-5 mx-2"/>
                        Back to top
                    </x-app.foot-menu>

                    <div class="flex items-center gap-4">
                        <x-app.foot-menu>
                            <x-icons.facebook class="w-6 h-6"/>
                        </x-app.foot-menu>
                        <x-app.foot-menu>
                            <x-icons.linkedin class="w-6 h-6"/>
                        </x-app.foot-menu>
                        <x-app.foot-menu>
                            <x-icons.facebook class="w-6 h-6"/>
                        </x-app.foot-menu>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    @livewireScriptConfig
</div>
</body>
</html>


