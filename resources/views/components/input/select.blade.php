@props( [
    'id',
    'name',
    'placeholder' => '',
    'label' => '',
    'options' => [],
    'variant' => 'col',
    'fontSize' => 'text-sm',
    'fontColor' => 'text-app',
    'associative' => true
] )

@php
    $classes = 'text-gray-600 h-10 bg-transparent block outline-none border-b-2 placeholder-secondary/80';

    if( $errors->has( $attributes->wire('model')->value() ) ){
        $classes .= ' border-b-red-400';
    } else {
        $classes .= ' border-b-secondary';
    }

    $classes .= ' ';
    $classes .= $fontSize;
    $classes .= ' ';
    $classes .= $fontColor;
@endphp

<div class="flex {{ $variant === 'col' ? 'flex-col' : 'flex-row' }}" wire:loading.class="opacity-50" wire:target="{{ $attributes->wire('model')->value() }}">
    <!-- label -->
    @if($label)
    <label class="block {{ $variant === 'col' ? 'mb-2' : 'flex items-center w-1/3' }} text-sm font-bold  @error($attributes->wire('model')->value()) text-red-400 @else text-secondary @enderror">{!! $label !!}</label>
    @endif

    <select
        name="{{ $name ?? '' }}"
        class="{{ $classes }} {{ $variant === 'col' ? '' : 'w-2/3' }}"
        {{ $attributes->thatStartWith('wire:') }}
        {{ $attributes->thatStartWith('x-') }}
    >
        @if ($placeholder != '')
            <option value="">{{ $placeholder }}</option>
        @endif
        @if( $associative )
            @foreach($options as $value => $option )
                <option value="{{ $value }}">{{ is_numeric( $option ) ? number_format( $option ) : $option }}</option>
            @endforeach
        @else
            @foreach($options as $option )
                <option value="{{ $option }}">{{ is_numeric( $option ) ? number_format( $option ) : $option }}</option>
            @endforeach
        @endif
    </select>

    @error($attributes->wire('model')->value())
        <span class="mt-2 text-xs text-orange">{{ $message }}</span>
    @enderror

</div>
