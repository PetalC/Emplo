@php
use RalphJSmit\Livewire\Urls\Facades\Url;
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full overflow-auto">
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

    @if( config( 'school.color-primary' ) )
        <style>
            :root{
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

<body class="font-app flex h-full flex-col bg-white antialiased max-w-vw" x-data="{}">
{{-- Toast --}}
<livewire:toasts/>

<div class="flex-col" id="root">
    <header class="block w-full">
        <nav class="w-full">
            <div class="px-4 relative z-50 lg:flex hidden justify-between py-4">
                {{-- left menu --}}
                <x-app.navigation.header.top-left variation="dark" />

                <x-app.navigation.header.top-right variation="dark" />

{{--                --}}{{-- right menu --}}
{{--                <div class="flex items-center" x-data="{ openWizard: false }">--}}
{{--                    @if( Auth::check() )--}}
{{--                        <div class="flex text-app gap-2 items-center cursor-pointer" x-on:click="openWizard = ! openWizard" >--}}
{{--                            <x-icon name="heroicon-o-wrench-screwdriver" class="w-8 h-8"/>--}}
{{--                            Service Wizard--}}
{{--                        </div>--}}

{{--                        <div x-show="openWizard" x-cloak>--}}
{{--                            <livewire:service-wizard.stepper  />--}}
{{--                        </div>--}}
{{--                        @role('School Admin')--}}
{{--                            <x-app.nav-menu--}}
{{--                                href="{{ route('school.dashboard') }}"--}}
{{--                            >--}}
{{--                                My Account--}}
{{--                            </x-app.nav-menu>--}}
{{--                        @endrole--}}
{{--                        @role('Job Seeker')--}}
{{--                            <x-app.nav-menu--}}
{{--                                href="{{ route('profile') }}"--}}
{{--                            >--}}
{{--                                My Account--}}
{{--                            </x-app.nav-menu>--}}
{{--                        @endrole--}}
{{--                    @else--}}
{{--                        <x-app.nav-menu variation="dark" href="{{ route('auth') }}" active="{{ Url::current() == 'auth' }}">--}}
{{--                            Login--}}
{{--                        </x-app.nav-menu>--}}
{{--                    @endif--}}
{{--                </div>--}}
            </div>

            <x-app.navigation.responsive/>

        </nav>
    </header>

    <main class="flex-auto items-center">
        {{ $slot ?? '' }}
    </main>

    <x-app.footer />


    {{ $slot_bottom ?? '' }}


</div>
@stack('scripts')
@livewireScriptConfig
</body>
</html>


