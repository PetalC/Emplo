<input 
    type="range" 
    {{ $attributes->get('id') }} 
    {{ $attributes->get('name') }} 
    {{ $attributes->thatStartWith('wire:') }} 
    {{ $attributes->thatStartWith('x-') }} 
    {{ $attributes->class('slide') }}
/>