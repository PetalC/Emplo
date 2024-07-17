@props([
	'elem_type' => 'button',
    'size' => 'md',
    'uppercase' => false,
    'shadow' => true,
])

@php
$element = ( $elem_type == 'link' ) ? 'a' : 'button';

$default_style = "inline-flex items-center text-white bg-tertiary border border-gray-600 rounded-md font-semibold hover:opacity-80 focus:outline-none focus:ring-2 disabled:opacity-25 transition ease-in-out duration-150 ";
$default_style .= ( $shadow ) ? "shadow-[0_15px_45px_-11px_rgba(0,0,0,0.3)] shadow-tertiary " : "";
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
