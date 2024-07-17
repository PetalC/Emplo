@props([
    'label',
    'icon',
])
<div {{ $attributes->merge( [ 'class' => 'flex flex-col gap-4 items-center px-4 py-4 xl:py-2 rounded border cursor-pointer' ]) }}>
    @if( $slot == '' )
        <x-icon name="{{ $icon }}" class="w-8 h-8 text-app" />
    @else
        {{ $slot }}
    @endif
    <span class="text-xs text-center">{{ $label }}</span>
</div>
