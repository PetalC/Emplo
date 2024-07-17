@props([
    'id',
    'name',
    'placeholder' => '',
    'user_address_results' => null,
    'address_click_callback' => 'handleAddressSelection',
])

<div {{ $attributes->merge( [ 'class' => 'col-span-4 relative']) }}>
    <div class="inline-flex items-center w-full border-b-2 border-b-gray-800 text-secondary">
        <input
            type="text"
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->whereStartsWith('wire:') }}
            class="text-secondary lg:text-sm font-medium block w-full py-3.5 outline-none bg-transparent"
        />

{{--        <x-icon name="heroicon-o-magnifying-glass" class="w-8 h-8 mr-5" />--}}
    </div>

    @if( $user_address_results )

        <div class="bg-white border border-gray-100 shadow-md mt-2 absolute top-[100%] left-0 z-50" >
            <ul class="divide-y divide-gray-100">
                @foreach( $user_address_results as $result )
{{--                    @click="showMapLocation( {{ $result['longitude'] }}, {{ $result['latitude'] }})" ( '{{ json_encode( $result ) }}' )--}}
                    <li class="py-2 px-3 hover:bg-gray-100 cursor-pointer text-sm" wire:click="handleAddressSelection( '{{ json_encode( $result ) }}' )">
                        <span>{{ $result['address'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    @endif

</div>

