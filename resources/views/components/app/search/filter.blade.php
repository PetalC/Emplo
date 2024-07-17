@props([
    'label',
    'image' => false,
    'icon',
])

<div x-data="{ open: false }" {{ $attributes->merge( [ 'class' => 'relative inline-flex lg:max-w-fit text-app px-4 py-2 rounded border cursor-pointer' ]) }} x-on:click.outside="open = false">
    <div class="relative flex flex-col items-center gap-4 cursor-pointer" x-on:click="open = true">
        @if( $image )
            <img class="max-w-9" src="{{ asset('assets/image_icons/' . $image ) }}" />
        @else
            <x-icon name="{{ $icon }}" class="w-8 h-8 text-gray-500 mx-auto" />
        @endif
        <span class="text-xs text-nowrap inline-block">{{ $label }} <x-icon name="heroicon-o-chevron-down" class="inline-block w-4 h-4" /></span>
    </div>

    <div
        x-cloak
        x-show="open"
        class="absolute bg-white drop-shadow-dropdown p-3 flex flex-col gap-3 rounded-lg top-full min-w-52 -translate-x-1/2 left-1/2 translate-y-2 z-20"
    >
        {{ $slot }}
    </div>
</div>
