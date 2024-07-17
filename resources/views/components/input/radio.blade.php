@props([
    'id',
    'name' => null,
    'label' => null,
    'value' => 0,
    'sr_only' => false
])

<div class="relative flex items-center">
    <div class="flex items-center h-5">
        <input 
            id="{{ $id }}" 
            @if ($name) name="{{ $name }}" @endif 
            {{ $attributes->whereStartsWith('x-') }} 
            {{ $attributes->whereStartsWith('wire:') }}
            type="radio" 
            value="{{ $value }}" 
            class="app-radio"
        >
    </div>
    <div class="ml-2">
        <label for="{{ $id }}" class="{{ $sr_only ? 'sr-only' : 'block font-bold text-sm text-gray-700' }}">{!! $label !!}</label>
    </div>
</div>