@props([
    'size' => 'md',
    'show' => false,
    'onClose' => null,
    'withClose' => true
])

@switch($size)
    @case('sm')
        @php
            $widthClass = "min-w-80";
        @endphp
    @break
    @case('md')
        @php
            $widthClass = "min-w-[496px]";
        @endphp
    @break
    @case('lg')
        @php
            $widthClass = "min-w-[600px]";
        @endphp
    @break
@endswitch

<div
    {{ $attributes->whereStartsWith('x-show') }}
    {{ $attributes->whereStartsWith('wire:') }}
    class="absolute z-50"
    x-cloak
>
    {{-- overlay --}}
    <div
        class="fixed inset-0 h-full w-full bg-gray-800 bg-opacity-50 z-50 overflow-hidden"
    ></div>

    {{-- modal --}}
    <div
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[60] overflow-auto max-h-[100vh] no-scrollbar"
        {{ $attributes->whereStartsWith('x-on:click.outside') }}
    >
        <div class="relative flex flex-col rounded-2xl bg-white p-10 my-20 {{ $widthClass }}">
            @if( $withClose )
                <div class="absolute top-4 right-4" x-on:click="{{ $onClose }}">
                    <x-icon name="heroicon-o-x-mark" class="w-6 h-6 text-app cursor-pointer" />
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
