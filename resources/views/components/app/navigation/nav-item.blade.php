@props([
    'href' => '#',
    'active' => false,
    'role' => 'guest',
])

@php
$textColor = '';

switch($role) {
    case 'guest':
        $textColor = !$active ? 'text-tertiary hover:text-primary ' : 'text-primary hover:text-primary ';
        break;
    case 'teacher':
        $textColor = $active ? 'text-white ' : 'text-white ';
        break;
}

$classes = 'relative px-3 transition-colors delay-150 hover:delay-0 ' . $textColor;
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => $classes]) }}
    {{ $attributes->thatStartWith('wire:') }}
    {{ $attributes->thatStartWith('x-') }}
>
    {{ $slot }}
</a>
