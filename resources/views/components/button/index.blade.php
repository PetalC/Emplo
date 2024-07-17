@props([
    'variant' => 'center'
])

@php
    $posClass = $variant == 'center' ? 'justify-center ' : 'justify-start '
@endphp

<button
    {{ $attributes->get( 'href' ) }}
    {{ $attributes->get('id') }}
    {{ $attributes->thatStartWith('wire:') }}
    {{ $attributes->thatStartWith('x-') }}
    {{ $attributes->class([
        $posClass . 'relative inline-flex items-center rounded-lg px-12 py-4 shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50',
        'w-fit' => !$attributes->get('fullWidth'),
        'w-full' => $attributes->get('fullWidth'),
       ])->merge(['type' => 'button']) }}>
    {{ $slot }}
</button>
