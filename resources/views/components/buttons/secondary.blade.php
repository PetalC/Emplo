@props([
	'elem_type' => 'button',
    'size' => 'md',
    'shadow' => false,
    'uppercase' => false,
//    'href' => '#'
])

@php
    $element = ( $elem_type == 'link' ) ? 'a' : 'button';
    $default_style = "inline-flex items-center bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 ";
    $default_style .= ( $uppercase ) ? "uppercase " : "";
    $default_style .= ( $shadow ) ? "shadow-[0_15px_30px_-11px_rgba(0,0,0,0.3)] shadow-secondary/50 " : "";

    //$default_style = "inline-flex items-center bg-white border border-gray-300 rounded-md font-semibold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 justify-center ";
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
