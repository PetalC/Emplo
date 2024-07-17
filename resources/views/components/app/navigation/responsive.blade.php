@php use RalphJSmit\Livewire\Urls\Facades\Url; @endphp

<div x-data="{ openNavigation: false }" class="w-full">

    <button x-on:click="openNavigation = ! openNavigation" class="lg:hidden block fixed top-5 sm:top-4 right-2 z-50">
        <div class="bg-white text-primary border-[3px] border-primary rounded-full flex items-center justify-center">
            <x-icon x-show="! openNavigation" name="heroicon-o-bars-3" class="font-bold w-6 h-6 sm:w-8 sm:h-8 m-1"/>
            <x-icon x-show="openNavigation" name="heroicon-o-chevron-down" class="font-bold w-8 h-8 m-1"/>
        </div>
    </button>

    <div x-show="openNavigation" x-cloak class="fixed w-full h-screen left-0 top-0 z-40" x-transition>

        <div  class="absolute w-full h-screen bg-black/30 z-[3]"></div>

        <div class="relative px-16 py-16 bg-white z-[5] text-left">

            <div class="max-w-48 mb-6">
                <x-app.logo.logo />
            </div>

            <x-app.navigation.responsive-nav-item href="{{ route('search') }}" active="{{ Url::currentRoute() == 'search' }}">
                Search
            </x-app.navigation.responsive-nav-item>

            <x-app.navigation.responsive-nav-item href="{{ route('candidates') }}" active="{{ Url::currentRoute() == 'candidates' }}">
                Candidates
            </x-app.navigation.responsive-nav-item>

            <x-app.navigation.responsive-nav-item href="{{ route('schools') }}" active="{{ Url::currentRoute() == 'schools' }}">
                Schools
            </x-app.navigation.responsive-nav-item>

            <x-app.navigation.responsive-nav-item href="{{ route('about') }}" active="{{ Url::currentRoute() == 'about' }}">
                About
            </x-app.navigation.responsive-nav-item>

            <x-app.navigation.responsive-nav-item href="{{ route('contact') }}" active="{{ Url::currentRoute() == 'contact' }}">
                Contact
            </x-app.navigation.responsive-nav-item>

            <x-app.navigation.responsive-nav-item href="{{ route('contact') }}" active="{{ Url::currentRoute() == 'myaccount' }}">
                My Account
            </x-app.navigation.responsive-nav-item>

        </div>

    </div>

</div>

