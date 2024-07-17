@props([
    'label',
    'icon',
])

<div x-data="{ open: false }" x-on:click.outside="open = false" class="relative inline-flex lg:max-w-fit text-secondary">
    <div class="relative flex flex-col items-center gap-4 cursor-pointer lg:w-fit w-[250px] box-border" x-on:click="open = true">
        <x-icon name="{{ $icon }}" class="w-8 h-8 text-gray-500 mx-auto" />

        <span class="text-sm text-nowrap inline-block">{{ $label }} <x-icon name="heroicon-o-chevron-down" class="inline-block w-4 h-4" /></span>

    </div>

    <div
        x-show="open"
        class="absolute bg-white drop-shadow-dropdown p-3 flex flex-col gap-3 rounded-lg top-full min-w-52 -translate-x-1/2 left-1/2 translate-y-2 z-20"
    >
        {{ $slot }}
    </div>
</div>
