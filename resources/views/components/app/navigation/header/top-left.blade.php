@props( [
    'variation' => 'light' //light | dark
] )
@php use Illuminate\Support\Facades\Route; @endphp
<div class="flex items-center">
    <x-app.nav-menu
        href="{{ route('search') }}"
        active="{{ Route::is( 'search' ) }}"
        :variation="$variation"
    >
        Search
    </x-app.nav-menu>
    <x-app.nav-menu
        href="{{ route('candidates') }}"
        active="{{ Route::is( 'candidates' ) }}"
        :variation="$variation"
    >
        Candidates
    </x-app.nav-menu>
    <x-app.nav-menu
        href="{{ route('schools') }}"
        active="{{ Route::is( 'schools' ) }}"
        :variation="$variation"
    >
        Schools
    </x-app.nav-menu>
    <x-app.nav-menu
        href="{{ route('about') }}"
        active="{{ Route::is( 'about' ) }}"
        :variation="$variation"
    >
        About
    </x-app.nav-menu>
    <x-app.nav-menu
        href="{{ route('contact') }}"
        active="{{ Route::is( 'contact' )  }}"
        :variation="$variation"
    >
        Contact
    </x-app.nav-menu>
</div>
