@props([
    'id',
    'name',
    'placeholder' => ''
])

<div {{ $attributes->whereStartsWith( 'class' )->merge( [ 'class' => 'inline-flex w-full border-gray-200 border border-secondary rounded-lg p-3'] ) }}>
    <input
        {{ $attributes->whereStartsWith( 'wire:' ) }}
        type="text"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        class="text-secondary text-sm font-medium block w-full px-2 py-2  outline-none bg-transparent"
    />
</div>
