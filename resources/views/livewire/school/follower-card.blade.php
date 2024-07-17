<div class="rounded-lg grid grid-cols-subgrid col-span-12 items-center p-5 border" x-data="{isChecked: @entangle( 'selected' ) }" :class="isChecked ? 'bg-green-100 border-green-400' : 'border-gray-500'">

    <div class="col-span-1">
        <x-input.checkbox wire:model.live="selected" x-model="isChecked" value="{{ $user->id }}" id="follower_checkbox_{{ $user->id }}" name="follower_checkbox_{{ $user->id }}" class="w-5 h-5 rounded-lg"/>
{{--        <input x-model="isChecked" type="checkbox" class="w-5 h-5 rounded-lg">--}}
    </div>

    <div class="col-span-5">

        <div class="flex flex-col lg:flex-row lg:items-start gap-4">
            <x-app.profile.avatar class="w-20 h-20 !px-2 !py-2 box-border" :user="$user"/>
{{--            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">--}}
{{--                <x-icon name="heroicon-o-user" class="text-white"/>--}}
{{--            </div>--}}
            <div class="text-app">
                <p class="text-xl text-center lg:text-left"><a target="_blank" href="{{ route( 'profile.view', $user ) }}">{{ $user->name }}</a></p>
                <p class="text-gray-300 mt-2 text-sm text-center lg:text-left">{{ $user->profile?->city }}, {{ $user->profile?->state }}</p>
                @if(!is_null($user->distance))
                    <p class="text-gray-300 mt-2 text-sm text-center lg:text-left">( {{ round($user->distance, 2) }} kms )</p>
                @endif
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-2 self-start col-span-3">
        @foreach( $user->subjects as $subject )
            <x-app.staffroom.candidate-type class="!py-1 !px-2" label="{{ $subject->name }}" />
        @endforeach
{{--        <x-app.staffroom.candidate-type class="!py-1 !px-2" label="Teaching" />--}}
{{--        <x-app.staffroom.candidate-type class="!py-1 !px-2" label="Mathematics" />--}}
{{--        <x-app.staffroom.candidate-type class="!py-1 !px-2" label="Chemistry" />--}}
{{--        <x-app.staffroom.candidate-type class="!py-1 !px-2" label="Physics" />--}}
    </div>

    <div class="col-span-3">
        <x-app.user.badges :user="$user" class="bg-opacity-50"/>
    </div>

</div>
