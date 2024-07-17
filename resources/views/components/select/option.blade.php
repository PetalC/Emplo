@props([
    'active' => false
])

@php
$finalClass = $active ? 'p-3 rounded-lg cursor-pointer text-white bg-primary' : 'p-3 rounded-lg cursor-pointer hover:bg-gray-100'
@endphp

<div {{ $attributes->merge(['class' => $finalClass]) }}>
    {{ $slot }}
</div>