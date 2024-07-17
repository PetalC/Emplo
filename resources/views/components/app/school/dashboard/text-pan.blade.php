@props([
    'number',
    'label',
    'color' => 'blue',
    'icon' => '',
    'link' => false,
])

@php
    $default_style = 'bg-sky-100 h-24 text-sky-600 flex'
@endphp

@switch($color)
    @case('blue')
        @php
            $default_style = 'bg-sky-100 h-24 text-sky-600 flex'
        @endphp
    @break
    @case('green')
        @php
        $default_style = 'bg-green-100 h-24 text-green-600 flex'
        @endphp
    @break
@endswitch
<div class="{{ $default_style }}">

    <div class="w-2/5 flex items-center justify-center text-5xl border-r-2 border-white">
        {{ $number }}
    </div>
    <div class="w-3/5 flex items-center">
        <div class="w-full flex items-center {{ $icon == '' ? 'justify-center' : 'justify-between' }} text-2xl px-5">
            @if($icon)
                <div></div>
            @endif
            @if( $link ) <a href="{{ $link }}"> @endif
                <p>{{ $label }}</p>
            @if( $link ) </a> @endif
            @if($icon)
                <div class="border-2 rounded-lg border-gray-500 p-2 text-gray-500">
                    <x-icon name="{{ $icon }}" class="w-5 h-5 "/>
                </div>
            @endif
        </div>
    </div>
</div>
