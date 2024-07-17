@props([
	'elem_type' => 'button',
	'tooltip' => false,
    'size' => 'md',
    'uppercase' => false,
    'shadow' => true,
])

@php
    $element = ( $elem_type == 'link' ) ? 'a' : 'button';
    $default_style = "text-white animate-gradient border border-transparent rounded-md text-center hover:opacity-80 active:bg-theme-secondary focus:outline-none transition ease-in-out duration-150 relative ";
    $default_style .= ( $shadow ) ? "shadow-[0_15px_45px_-11px_rgba(0,0,0,0.3)] shadow-primary " : "";
    $default_style .= ( $uppercase ) ? "uppercase " : "";
@endphp

@switch($size)
    @case('md')
        @php
            $sizeClass = "text-sm px-6 py-2";
        @endphp
        @break
    @case('lg')
        @php
            $sizeClass = "text-lg font-normal px-6 py-2";
        @endphp
        @break
    @case('3xl')
    @case('xl')
        @php
            $sizeClass = "text-2xl font-normal px-6 py-2";
        @endphp
        @break
@endswitch

<{{$element}} {{ $attributes->merge(['type' => ( $elem_type == 'link' ) ? '' : 'button', 'class' => $default_style . $sizeClass]) }}>
    {{ $slot }}
</{{$element}}>

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
