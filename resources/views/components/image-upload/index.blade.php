@props([
    'id',
    'multiple' => false,
    'preview' => null,
    'accept' => 'image/png, image/jpeg'
])

<form 
    {{ $attributes->whereStartsWith('wire:submit') }} 
    {{ $attributes->merge(['class' => "inline-flex w-full h-full border border-app rounded-lg overflow-hidden"]) }}
>
    <input 
        id="{{ $id }}"
        type="file" 
        {{ $attributes->whereStartsWith('wire:model') }}
        {{ $multiple ? 'multiple' : '' }}
        accept="{{ $accept }}"
        hidden
    />
    <div 
        class="inline-flex w-full h-full items-center justify-center" 
        onclick="document.getElementById('{{ $id }}').click();"
    >
        @if($preview)
        {{ $preview }}
        @else
        <div class="flex flex-col items-center">
            <img src="{{ asset('assets/app/image-upload.png') }}" class="object-contain w-20 h-20" />
        </div>
        @endif
    </div>
</form>