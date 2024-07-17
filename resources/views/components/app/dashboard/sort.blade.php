@props([
    'label',
    'icon',
])

<div class="flex flex-col items-center gap-4 cursor-pointer">
    <x-icon name="{{ $icon }}" class="w-8 h-8" />

    <span class="text-sm">Sort</span>
</div>