@props([
    'id',
    'name',
])

<div class="relative inline-block w-14 align-middle select-none transition duration-200 ease-in">
    <input 
        type="checkbox" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        {{ $attributes->whereStartsWith('x-') }} 
        {{ $attributes->whereStartsWith('wire:') }} 
        class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-primary m-1 border border-white appearance-none cursor-pointer"
    />
    <label for="{{ $id }}" class="toggle-label block overflow-hidden h-8 rounded-full bg-white cursor-pointer border box-border"></label>
</div>