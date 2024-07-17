@props([])

<div {{ $attributes->merge(['class' => 'inline-flex lg:rounded-2xl rounded-0 bg-white border border-gray-100 shadow-md']) }}>
    {{ $slot }}
</div>
