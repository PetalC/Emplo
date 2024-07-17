@props([
    'id',
    'name',
    'label' => '',
    'placeholder' => '',
    'type' => 'text',
    'helper' => '',
    'leftIcon' => '',
    'rightIcon' => '',
    'variant' => 'col',
    'width' => '',
    'bgColor' => ''
])

@php
@endphp
<div class="flex {{ $variant == 'col' ? 'flex-col' : 'flex-row items-center gap-5' }} w-full">
    <!-- label -->
    @if($label)
    <label for="{{ $id }}" class="block mb-2 text-sm text-gray-500 {{ $variant == 'col' ? '' : 'w-2/5 font-bold text-nowrap' }}">{{ $label }}</label>
    @endif

    <!-- input -->
    <div class="flex h-14 border rounded-lg overflow-hidden border-gray-300">
        @if($leftIcon)
        <span class="inline-flex items-center px-3.5 bg-gray-100">
            <x-icon name="{{ $leftIcon }}" class="w-4 h-4" />
        </span>
        @endif
        <input
            type="{{ $type }}"
{{--            id="{{ $id }}" --}}
{{--            name="{{ $name }}" --}}
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'text-gray-600 text-sm block px-4 outline-none ' . $bgColor]) }}
        />
        @if($rightIcon)
        <span class="inline-flex items-center px-3.5">
            <x-icon name="{{ $rightIcon }}" class="w-4 h-4" />
        </span>
        @endif
    </div>

    <!-- helper text -->
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
</div>
