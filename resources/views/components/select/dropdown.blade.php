@props([
    'label',
    'icon' => 'heroicon-o-chevron-down'
])

<div x-data="{ open: false }" x-on:click.outside="open = false" class="relative inline-flex text-secondary">
    <div {{ $attributes->whereStartsWith( 'class' )->merge( [ 'class' => 'relative flex flex-col items-center gap-4 cursor-pointer box-border' ]) }} x-on:click="open = true">
        <span class="text-sm text-nowrap inline-block">{{ $label }} <x-icon name="{{ $icon }}" class="inline-block w-4 h-4" /></span>
    </div>

    <div x-show="open" x-cloak
        class="absolute bg-white drop-shadow-dropdown p-2 flex flex-col gap-2 rounded-lg top-full -translate-x-1/2 left-1/2 translate-y-5 z-20"
    >
        {{ $slot }}
    </div>
</div>
