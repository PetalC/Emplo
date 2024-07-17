@props([
	'elem_type' => 'button',
    'size' => 'md',
    'shadow' => true,
    'uppercase' => false,
])

@php
$element = ( $elem_type == 'link' ) ? 'a' : 'button';

$default_style = "inline-flex items-center px-3 py-2 bg-success border border-sky-600 rounded-md text-gray-700 shadow-sm hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 ";
$default_style .= ( $shadow ) ? "shadow-[0_15px_45px_-11px_rgba(0,0,0,0.3)] shadow-success " : "";
$default_style .= ( $uppercase ) ? "uppercase " : "";
@endphp

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

<{{$element}} {{ $attributes->merge(['type' => ( $elem_type == 'link' ) ? '' : 'button', 'class' => $default_style . $sizeClass]) }}>
    {{ $slot }}
</{{$element}}>

