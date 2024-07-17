@props([

])

<h4 {{ $attributes->merge( [ 'class' => 'text-app text-[1.8rem] font-light' ] ) }}>
    {{ $slot }}
</h4>

