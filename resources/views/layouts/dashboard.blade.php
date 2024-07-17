@php use Illuminate\Support\Facades\Auth;use RalphJSmit\Livewire\Urls\Facades\Url; @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset( 'assets/favicon.png' ) }}">

    <title>{{ $title ?? 'Employo - Built For Education' }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/xjv3llh.css">

    {{-- mapbox --}}
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- datepicker --}}
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

    {{-- Rich text --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.snow.css" rel="stylesheet">

    @if( config( 'school.color-primary' ) )
        <style>
            :root {
                --school-primary-color: {{ config( 'school.color-primary', '#0ea5e9' ) }};
                --school-primary-color-alt: {{ config( 'school.color-primary', '#0ea5e9' ) . '4D' }};
                --school-secondary-color: {{ config( 'school.color-secondary', '#0ea5e9' ) }};
                --school-tertiary-color: {{ config( 'school.color-tertiary', '#0ea5e9' ) }};
            }
        </style>
    @endif

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
        <nav>
            <div class="px-4 relative z-50 lg:flex hidden justify-between py-4 bg-school_primary">
                {{-- left menu --}}
                <x-app.navigation.header.top-left variation="light" />

                <x-app.navigation.header.top-right variation="light" />


{{--                --}}{{-- right menu --}}
{{--                <div class="flex items-center" x-data="{ openWizard: false }">--}}
{{--                    @if( Auth::check() )--}}
{{--                        --}}{{--                        <div class="flex text-white gap-2 items-center cursor-pointer" x-on:click="openWizard = ! openWizard" >--}}
{{--                        --}}{{--                            <x-icon name="heroicon-o-wrench-screwdriver" class="w-8 h-8"/>--}}
{{--                        --}}{{--                            Service Wizard--}}
{{--                        --}}{{--                        </div>--}}

{{--                        --}}{{--                        <div x-show="openWizard" x-cloak>--}}
{{--                        --}}{{--                            <livewire:service-wizard.stepper  />--}}
{{--                        --}}{{--                        </div>--}}
{{--                        @if( Auth::user()->schools()->count() > 1 )--}}
{{--                            <x-app.nav-menu--}}
{{--                                href="{{ route('school.select_school') }}"--}}
{{--                                active="{{ Url::currentRoute() == 'school.select_school' }}"--}}
{{--                                role="teacher"--}}
{{--                            >--}}
{{--                                My Schools--}}
{{--                            </x-app.nav-menu>--}}
{{--                        @endif--}}
{{--                        <x-app.nav-menu--}}
{{--                            href="{{ route('auth') }}"--}}
{{--                            active="{{ Url::currentRoute() == 'auth' }}"--}}
{{--                            role="teacher"--}}
{{--                        >--}}
{{--                            My Account--}}
{{--                        </x-app.nav-menu>--}}
{{--                        <form method="POST" action="{{ route('logout') }}">--}}
{{--                            @csrf--}}
{{--                            <button--}}
{{--                                class="relative px-3 transition-colors delay-150 hover:delay-0 text-white"--}}
{{--                                type="submit"--}}
{{--                            >--}}
{{--                                Logout--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    @else--}}
{{--                        <x-app.nav-menu--}}
{{--                            href="{{ route('auth') }}"--}}
{{--                            active="{{ Url::currentRoute() == 'auth' }}"--}}
{{--                            role="teacher"--}}
{{--                        >--}}
{{--                            Login--}}
{{--                        </x-app.nav-menu>--}}
{{--                    @endif--}}
{{--                </div>--}}
            </div>

            <x-app.navigation.responsive/>

            <div class="pt-14 lg:pb-0 pb-32 bg-school_primary">
                <div class="w-full lg:flex hidden justify-end gap-2">
                    <div class="w-3/4">
                        <div class="w-full justify-center flex items-center">
                            <x-app.profile.tab-menu
                                href="{{ route('school.dashboard') }}"
                                icon="heroicon-s-chart-bar-square"
                                label="Dashboard"
                                active="{{ Url::currentRoute() == 'school.dashboard' }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.campus_profile') }}"
                                icon="heroicon-s-arrow-path"
                                label="Employer Profile"
                                active="{{ Url::currentRoute() == 'school.campus_profile' }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.staffroom.candidates') }}"
                                icon="heroicon-s-user-group"
                                label="Staffroom"
                                active="{{ Url::currentRoute() == 'school.staffroom.candidates' }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.jobcenter.index') }}"
                                icon="heroicon-s-megaphone"
                                label="Job Center"
                                active="{{ \Illuminate\Support\Facades\Route::is( 'school.jobcenter.*' ) }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.applicants') }}"
                                icon="heroicon-s-arrow-trending-up"
                                label="ATS"
                                active="{{ Url::currentRoute() == 'school.applicants.view' || Url::currentRoute() == 'school.applicants' }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.resources') }}"
                                icon="heroicon-s-book-open"
                                label="Resource Library"
                                active="{{ Url::currentRoute() == 'school.resources' }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('school.settings') }}"
                                icon="heroicon-s-cog"
                                label="Settings"
                                active="{{ Url::currentRoute() == 'school.settings' }}"
                            />
                        </div>
                    </div>
                </div>
                <div class="lg:hidden block">
                    <img src="{{ asset('assets/app/white-logo.png') }}" class="min-h-22  mx-auto"/>
                </div>
            </div>
        </nav>
    </header>

    <main class="relative flex-auto">
        {{ $slot ?? '' }}
    </main>

    <x-app.footer/>

    @stack('scripts')
    @livewireScriptConfig
</div>
</body>
</html>
