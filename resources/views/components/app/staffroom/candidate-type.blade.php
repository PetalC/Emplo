@props([
    'label' => ''
])

<div>
    @if($label === 'Teaching')
        <x-badge variant="error" {{ $attributes->whereStartsWith( 'class' ) }}>{{ $label }}</x-badge>
    @else
        <x-badge variant="info" {{ $attributes->whereStartsWith( 'class' ) }}>{{ $label }}</x-badge>
    @endif
</div>
