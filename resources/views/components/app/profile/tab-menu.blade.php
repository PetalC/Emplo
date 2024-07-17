@props([
    'href',
    'icon',
    'label' => '',
    'active' => false,
])

@php
$color = !$active ? 'text-white' : 'bg-white text-app';

$classes = 'relative flex items-center py-3 px-8 cursor-pointer rounded-t-lg ' . $color;
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    <x-dynamic-component :component="$icon" class="w-4 h-4" />
{{--    <x-icon name="{{ $icon }}" class="w-4 h-4" />--}}
    <span class="ml-2">{{ $label }}</span>
</a>
