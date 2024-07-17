@props([
    'label' => '',
    'enabled' => 'true'
])

@php
    $textColor = '';
    $textColor = $enabled ? 'text-yellow-400' : 'text-gray-400';
@endphp
<div>
    <x-icon name="heroicon-c-shield-check" class="w-7 h-7 {{ $textColor }}"></x-icon>
    <p class="mt-1 text-center">{{ $label }}</p>
</div>