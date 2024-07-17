@props([
    'label',
    'icon',
    'active' => false
])

<div {{ $attributes->merge( [ 'class' => 'lg:w-fit w-[250px]' ] ) }}>
    <div class="flex flex-col items-center gap-4 cursor-pointer lg:w-fit w-[250px]">
        <x-icon name="{{ $icon }}" class="w-8 h-8 text-gray-500" />

        <span class="text-sm  text-nowrap">{{ $label }}</span>
    </div>
</div>
