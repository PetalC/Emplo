@props([
    'href' => 'javascript:void(0)'
])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'relative text-sm text-gray-700 transition-colors delay-150 hover:text-primary hover:delay-0']) }}
    {{ $attributes->thatStartWith('wire:') }}
    {{ $attributes->thatStartWith('x-') }}
>
    {{ $slot }}
</a>
