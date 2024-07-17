@props([
    'size' => 'md',
    'variant' => 'center'
])

@switch($size)
    @case('sm')
        @php
            $sizeClass = "";
        @endphp
    @break
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

<x-button type="submit" variant="{{ $variant }}" {{ $attributes->merge(['class' => 'text-primary border border-primary bg-white ' . $sizeClass]) }}>
    {{ $slot }}
</x-button>