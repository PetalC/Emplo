@props([
    'size' => 'md',
    'elem_type' => 'button',
])

@switch($size)
    @case('md')
        @php
            $sizeClass = "text-sm";
        @endphp
    @break
    @case('lg')
        @php
            $sizeClass = "text-normal font-semibold";
        @endphp
    @break
@endswitch

<x-button type="{{ $elem_type }}" {{ $attributes->merge(['class' => 'bg-tertiary text-white ' . $sizeClass]) }}>
    {{ $slot }}
</x-button>
