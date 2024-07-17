@props( [
    'variation' => 'light' //light | dark
] )
@php use Illuminate\Support\Facades\Route; @endphp
<div class="flex items-center">

    @if( env('APP_ENV') !== 'production' )

        <div x-data="{ openWizard: false }">
            <div class="flex text-app gap-2 items-center cursor-pointer" x-on:click="openWizard = ! openWizard" >
                <x-icon name="heroicon-o-wrench-screwdriver" class="w-8 h-8"/>
                Service Wizard
            </div>

            <div x-show="openWizard" x-cloak>
                <livewire:service-wizard.stepper  />
            </div>
        </div>

    @endif

    @if( auth()->check() )

        @if( auth()->user()->can( 'school.view-dashboard' ) )

            <x-app.nav-menu
                href="{{ route('school.dashboard') }}"
{{--                active="{{ Route::is( 'school.dashboard' )  }}"--}}
                :variation="$variation"
            >
                School Dashboard
            </x-app.nav-menu>

        @endif

        @if( auth()->user()->schools->count() > 1)

                <x-app.nav-menu
                    href="{{ route('school.select_school') }}"
                    :variation="$variation"
                >
                    My Schools
                </x-app.nav-menu>

        @endif

            @if( session()->get( 'current_school' )?->campuses->count() > 1)

                <x-app.nav-menu
                    href="{{ route('school.campuses') }}"
                    :variation="$variation"
                >
                    My Campuses
                </x-app.nav-menu>

            @endif

        @if( auth()->user()->can( 'nova.view' ) )

            <x-app.nav-menu
                href="{{ route('nova.pages.home') }}"
                :variation="$variation"
            >
                Super Admin Dashboard
            </x-app.nav-menu>

        @endif

        @if( auth()->user()->can( 'jobseeker.all' ) )
            <x-app.nav-menu
                href="{{ route('profile') }}"
{{--                    active="{{ Route::is( 'nova.pages.home' )  }}"--}}
                :variation="$variation"
            >
                My Profile
            </x-app.nav-menu>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="relative px-3 hover:text-primary transition-colors delay-150 hover:delay-0 {{ $variation === 'dark' ? 'text-tertiary' : 'text-white'  }}"
                type="submit"
            >
                Logout
            </button>
        </form>

    @else

        <x-app.nav-menu
            href="{{ route('auth') }}"
            active="{{ Route::is( 'auth' )  }}"
            :variation="$variation"
        >
            Login
        </x-app.nav-menu>

    @endif

</div>
