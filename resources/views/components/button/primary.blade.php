@props([
    'size' => 'md',
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
    @case('3xl')
        @php
            $sizeClass = "text-3xl font-semibold";
        @endphp
    @break
@endswitch

<x-button type="submit" {{ $attributes->merge(['class' => 'animate-gradient text-white drop-shadow-primary ' . $sizeClass]) }}>
    {{ $slot }}
</x-button>

<style>
@keyframes gradient {
    0%, 100% {
        background-color: #4d8c27;
    }
    50% {
        background-color: #185f0a;
    }
}

.animate-gradient {
    animation: gradient 5s infinite;
}

</style>