@props([
    'href' => '#',
    'active' => false,
    'role' => 'guest',
])

@php
    $textColor = '';

    switch($role) {
        case 'guest':
            $textColor = !$active ? 'text-black border-b-gray-400 hover:text-primary ' : 'text-primary hover:text-primary border-b-gray-400';
            break;
        case 'teacher':
            $textColor = $active ? 'text-white ' : 'text-white ';
            break;
    }

    $classes = 'text-2xl border-b font-light  block py-4 transition-colors transition hover:delay-0 ' . $textColor;
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => $classes]) }}
    {{ $attributes->thatStartWith('wire:') }}
    {{ $attributes->thatStartWith('x-') }}
>
    {{ $slot }}
</a>
