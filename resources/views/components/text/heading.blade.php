@props([
    'variant' => 'custom'
])

@switch($variant)
    @case('h1')
        @php
            $finalClass = 'text-[46px] font-light';
        @endphp
    @break
    @case('h3')
        @php
            $finalClass = 'text-5xl font-light';
        @endphp
    @break
    @case('h5')
        @php
            $finalClass = 'text-4xl font-light';
        @endphp
    @break
    @case('custom')
@endswitch

<h2 {{ $attributes->merge( [ 'class' => $finalClass ?? '' ] ) }}>
    {{ $slot }}
</h2>

