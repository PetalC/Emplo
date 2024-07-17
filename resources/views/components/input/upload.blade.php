@props([
    'id',
    'multiple' => false,
    'media' => null,
    'accept' => 'application/pdf, application/msword'
])

<div
{{--    {{ $attributes->whereStartsWith('wire:submit') }}--}}
    {{ $attributes->merge(['class' => "border border-app rounded-lg overflow-hidden bg-white"]) }}
>
    <input
        id="{{ $id }}"
        type="file"
        {{ $attributes->whereStartsWith('wire:model') }}
        {{ $multiple ? 'multiple' : '' }}
        accept="{{ $accept }}"
        hidden
    />
    <div class="cursor-pointer" onclick="document.getElementById('{{ $id }}').click();">
        @if($media)
            {{ $media }}
        @elseif( $slot->isEmpty() )
            <div class="p-6">
                <x-icon name="zondicon-cloud-upload" class="w-16 h-16 text-gray-300" />
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
</div>
