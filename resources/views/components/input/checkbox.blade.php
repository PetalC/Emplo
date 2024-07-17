@props([
    'id' => uniqid('checkbox-'),
    'name' => null,
    'label' => null,
    'value' => 0,
    'sr_only' => false,
    'disabled' => false,
    'display_errors' => true,
])

<div>

    <div class="flex items-center h-5 gap-2 {{ $disabled ? 'cursor-not-allowed' : ''}}">
        <input
            id="{{ $id }}"
            {{ $disabled ? 'disabled' : ''}}
            @if ($name) name="{{ $name }}" @endif
            {{ $attributes->whereStartsWith('x-') }}
            {{ $attributes->whereStartsWith('wire:') }}
            {{ $attributes->whereStartsWith('checked') }}
            type="checkbox"
            value="{{ $value }}"
            class="accent-primary app-checkbox"
        >
        <label for="{{ $id }}" class="{{ $sr_only ? 'sr-only' : 'block font-bold text-sm text-gray-700' }}">{!! $label !!}</label>
    </div>

    @if( $display_errors )
        @error($attributes->wire('model')->value())
        <div class="mt-2 text-xs text-danger">{{ $message }}</div>
        @enderror
    @endif

</div>
