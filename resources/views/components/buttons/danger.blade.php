@props([
	'elem_type' => 'button',
	'tooltip' => false,
    'size' => 'md',
    'uppercase' => false,
    'shadow' => true,
])

@php
    $element = ( $elem_type == 'link' ) ? 'a' : 'button';
    $default_style = "text-white inline-flex justify-around items-center bg-danger border border-transparent rounded-md text-center font-semibold focus:outline-none transition ease-in-out duration-150 relative ";
    $default_style .= ( $shadow ) ? "shadow-[0_15px_45px_-11px_rgba(0,0,0,0.3)] shadow-danger " : "";
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
            $sizeClass = "text-sm px-6 py-3";
        @endphp
        @break
    @case('3xl')
    @case( 'xl' )
        @php
            $sizeClass = "text-xl px-12 py-3 font-light";
        @endphp
        @break
    @default
        @php
            $sizeClass = "text-xs px-3 py-2";
        @endphp
@endswitch

<{{$element}} {{ $attributes->merge(['type' => ( $elem_type == 'link' ) ? '' : 'button', 'class' => $default_style . $sizeClass]) }}>
{{ $slot }}
</{{$element}}>
