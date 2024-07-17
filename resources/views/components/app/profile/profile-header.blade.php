@props([
    'user' => Auth::user(),
])
@php use Illuminate\Support\Facades\Auth; @endphp
<x-app.common.page_header>
    <x-slot name="column_left">
        <div class="max-w-52">
            <x-app.profile.avatar :user="$user" class="w-full justify-center flex !px-0 !py-0"/>

            @if( $user->is( Auth::user() ) )
                <div class="pt-6">
                    <x-buttons.primary class="w-full block py-2 !text-lg" :shadow="false" elem_type="link" href="{{ route('profile.edit') }}">Edit profile</x-buttons.primary>
                </div>
            @endif
        </div>
    </x-slot>
{{--    <x-slot name="column_right">--}}
{{--        <div class="pt-10">--}}
{{--            <x-buttons.primary :shadow="false" href="{{ route('profile.edit') }}">Edit profile</x-buttons.primary>--}}
{{--        </div>--}}
{{--    </x-slot>--}}

    <div class="col-span-8 flex flex-col gap-6 items-center pt-10 text-app">

        <div class="text-center">
            <h1 class="text-5xl font-light mb-3">{{ $user->name }}</h1>
            <p class="text-lg font-light">Lives in {{ $user->profile->state }}, {{ $user->profile->country }}</p>
        </div>

        @if( $user->current_position_types()->exists() )
            <p class="text-3xl font-light">{{ join( ', ', $user->current_position_types()->pluck( 'name' )->toArray() ) }}</p>
        @endif



        <div class="flex flex-col xl:flex-row justify-center gap-2 items-center text-gray-500">
            @foreach( $user->subjects as $subject )
                <x-badge>{{ $subject->name }}</x-badge>
            @endforeach
        </div>

        <div class="text-center">

            <div class="flex gap-2 justify-center items-center text-3xl">
                <span class="text-primary">${{ number_format( $user->profile->minimum_salary ) }}</span>
                <span class="text-primary">-</span>
                <span class="text-primary">${{ number_format( $user->profile->maximum_salary ) }}</span>
            </div>
            <p class="text-md">Salary Expectation</p>

        </div>

        {{ $slot }}

    </div>

</x-app.common.page_header>
