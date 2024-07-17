@props([
    'id',
    'name',
    'label' => '',
    'disabled' => false,
    'placeholder' => '',
    'rows' => 3,
    'characterLimit' => -1
])

@php
$has_error = $errors->has($attributes->wire('model')->value());
@endphp

<div class="flex flex-col" x-data="{ count: {{ $characterLimit }} }" wire:loading.class="opacity-50" wire:target="{{ $attributes->wire('model')->value() }}">
    <!-- label -->
    @if( $label || $characterLimit != -1 )
    <div class="flex justify-between">
        @if( $label )
            <label class="block mb-2 text-sm font-bold {{ $has_error ? 'text-red-400' : 'text-secondary' }}">{{ $label }}</label>
        @else
{{--            //Add an empty div to maintain the space--}}
            <div></div>
        @endif
        @if ($characterLimit != -1)
            <p x-text="`${count} characters remaining`" class="text-sm text-gray-500 mt-1 mb-2"></p>
        @endif
    </div>
    @endif

    <textarea wire:cloak
        placeholder="{{ $placeholder ?? '' }}"
        x-on:input="count = {{ $characterLimit }} - $event.target.value.length"
        maxlength="{{ $characterLimit }}"
        {{ $attributes->merge(['class' => 'text-gray-600 text-sm block w-full outline-none border-b-2 placeholder-secondary/80 bg-gray-50 p-5 ' . ( $has_error ? 'border-b-red-400' : 'border-b-secondary' ) ] ) }}
        rows={{ $rows }}
    ></textarea>

    @error($attributes->wire('model')->value())
    <span class="mt-2 text-xs text-orange">{{ $message }}</span>
    @enderror

</div>

