@props([
    'id',
    'name',
    'label' => '',
    'type' => 'text',
    'disabled' => false,
    'placeholder' => '',
    'variant' => 'col',
    'fontSize' => 'text-sm',
])

@php
    $classes = 'text-gray-600 block w-full outline-none border-b-2 placeholder-secondary/80 disabled:bg-white ';

    if( $errors->has( $attributes->wire('model')->value() ) ){
        $classes .= ' border-b-red-400';
    } else {
        $classes .= ' border-b-secondary ';
    }
    $classes .= $fontSize;
@endphp

<div class="w-full flex {{ $variant === 'col' ? 'flex-col' : 'flex-row' }} {{ !$disabled ? '' : 'opacity-50' }}" wire:loading.class="opacity-50" wire:target="{{ $attributes->wire('model')->value() }}">
    <!-- label -->
    @if($label)
    <label  class="block {{ $variant === 'col' ? 'mb-2' : 'flex items-center w-1/3' }} text-sm font-bold @error($attributes->wire('model')->value()) text-red-400 @else text-secondary @enderror">{{ $label }}</label>
    @endif

    <div class="flex h-10 overflow-hidden {{ $variant === 'col' ? '' : 'w-2/3' }}">
        <input
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $classes]) }}
            {{ $disabled ? 'disabled' : '' }}
        />
    </div>

    @error($attributes->wire('model')->value())
    <span class="mt-2 text-xs text-orange">{{ $message }}</span>
    @enderror
</div>

