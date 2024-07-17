<div x-data="{ showDropdown: @entangle( 'show_dropdown' ) }" class="relative w-full {{ $variant === 'row' ? 'flex items-center' : '' }}" wire:loading.class="opacity-50">

    @if($label)
        <label class="block text-sm font-bold {{ $error_message ? 'text-red-400' : 'text-secondary' }} {{ $variant === 'row' ? 'w-1/3' : '' }}">{{ $label }}</label>
    @endif


    <div class="border-b-2 h-12 flex flex-col justify-end pb-2 text-sm {{ $variant === 'row' ? 'w-2/3' : 'w-full' }} {{ $error_message ? 'border-b-red-400' : 'border-b-gray-800' }}"  x-on:click="showDropdown = !showDropdown">
        {{ $selected_text ?: $placeholder }}
    </div>
    <div x-show="showDropdown" x-on:click.away="showDropdown = ! showDropdown" class="absolute top-full w-full left-0 bg-white border border-gray-300 rounded-b-lg z-20 -translate-y-[1px] shadow">
        <div class="flex gap-2 items-center px-6 py-4">
            <x-input.outline wire:model.live="search_value" id="searchselect_search" name="searchselect_search" type="text" placeholder="Search" />
        </div>

        <div class="divide-y divide-gray-100 px-6 py-4">
            @if( $options )
                @foreach( $options as $id => $option )
                    <p class="text-md font-semibold p-2 cursor-pointer hover:bg-gray-100 transition-all {{ in_array( $id, $options ) ? 'bg-gray-50' : '' }}" wire:click="handleSelectOption( '{{ $id }}' )">{{ $option }}</p>
                @endforeach
            @else
{{--                <x-notifications.notice>No Options Found</x-notifications.notice>--}}
            @endif
        </div>

{{--        @if( $create_new )--}}
{{--            <div class="flex gap-2 items-center px-6 py-4 bg-theme-light">--}}
{{--                <x-forms.input.text wire:model="create_new_value" type="text" placeholder="Create New" />--}}
{{--                --}}{{--                <input class="my-2 border border-gray-300 rounded w-full py-2 text-sm font-semibold active:border-theme-primary"   />--}}
{{--                <x-buttons.secondary wire:click="handleCreateNew()">Add</x-buttons.secondary>--}}
{{--            </div>--}}
{{--        @endif--}}

    </div>

    @if( $error_message )
        <span class="mt-2 text-xs text-orange">{{ $error_message }}</span>
    @enderror

</div>
