@props([
    // Used for loading school colour on public pages (job/apply etc)
    'campus' => false,
])
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

    {{-- datepicker --}}
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

    @php
    if ($campus) {
        $color = $campus->primary_profile->branding_color_primary;
    } else {
        $color = config( 'school.color-primary' ) ?? '#0ea5e9';
    }
    @endphp
    @if( $color )
        <style>
            :root {
                --school-primary-color: {{ $color }};
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

<body class="font-app flex h-full flex-col bg-white antialiased" id="body">
{{-- Toast --}}
<livewire:toasts/>

<div class="flex min-h-full flex-col">
    <header>
        <nav class="min-h-44 bg-school_primary">
            <div class="px-4 relative z-50 flex justify-between py-4">
                {{-- left menu --}}
                <x-app.navigation.header.top-left />

                <x-app.navigation.header.top-right />

            </div>

            {{--            <div class="pt-14 bg-third">--}}
            {{--                <div class="w-full flex justify-end gap-2">--}}
            {{--                    <div class="w-3/4">--}}
            {{--                        <div class="w-full justify-center flex items-center">--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="{{ route('school.dashboard') }}"--}}
            {{--                                icon="heroicon-s-chart-bar-square"--}}
            {{--                                label="Dashboard"--}}
            {{--                                active="{{ $currentRoute == 'school.dashboard' }}"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="{{ route('school.campuses') }}"--}}
            {{--                                icon="heroicon-s-arrow-path"--}}
            {{--                                label="Employer Profile"--}}
            {{--                                active="{{ $currentRoute == 'school.campuses' }}"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="#"--}}
            {{--                                icon="heroicon-s-user-group"--}}
            {{--                                label="Staffroom"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="#"--}}
            {{--                                icon="heroicon-s-megaphone"--}}
            {{--                                label="Job Center"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="{{ route('school.applicants') }}"--}}
            {{--                                icon="heroicon-s-arrow-trending-up"--}}
            {{--                                label="ATS"--}}
            {{--                                active="{{ $currentRoute == 'school.applicants' }}"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="{{ route('school.resources') }}"--}}
            {{--                                icon="heroicon-s-book-open"--}}
            {{--                                label="Resource Library"--}}
            {{--                                active="{{ $currentRoute == 'school.resources' }}"--}}
            {{--                            />--}}
            {{--                            <x-app.teacher.tab-menu--}}
            {{--                                href="#"--}}
            {{--                                icon="heroicon-s-cog"--}}
            {{--                                label="Settings"--}}
            {{--                            />--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
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
