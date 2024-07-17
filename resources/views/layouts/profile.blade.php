@php use Illuminate\Support\Facades\Route; @endphp
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

    @livewireStyles
    @vite('resources/css/app.css')
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
            <div class="px-4 relative z-50 flex justify-between py-4 bg-primary">
                <x-app.navigation.header.top-left />
                <x-app.navigation.header.top-right />
            </div>

            <div class="pt-14 bg-gradient-to-b from-primary to-green-800/95">
                <div class="max-w-8xl mx-auto flex flex-col">
                    <div class="grid grid-cols-5">
                        <div class="col-span-3 col-start-2 flex items-center">
                            <x-app.profile.tab-menu
                                href="{{ route('search') }}"
                                icon="heroicon-o-magnifying-glass"
                                label="Search"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('profile') }}"
                                icon="heroicon-s-user"
                                label="My Profile"
                                active="{{ Route::is( 'profile' ) || Route::is( 'profile.edit' ) }}"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('profile.applications') }}"
                                active="{{ Route::is( 'profile.applications' ) }}"
                                icon="heroicon-s-document-text"
                                label="My Applications"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('profile.jobs') }}"
                                active="{{ Route::is( 'profile.jobs' ) }}"
                                icon="heroicon-s-bookmark"
                                label="Saved Jobs"
                            />
                            <x-app.profile.tab-menu
                                href="{{ route('profile.schools') }}"
                                active="{{ Route::is( 'profile.schools' ) }}"
                                icon="heroicon-c-plus"
                                label="Schools Followed"
                            />
                        </div>
                    </div>
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
