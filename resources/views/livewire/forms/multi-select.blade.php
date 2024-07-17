<div x-data="{ showDropdown: @entangle( 'show_dropdown' ) }" class="relative w-full {{ $variant === 'row' ? 'flex items-center' : '' }}" wire:loading.class="opacity-50">

    @if($label)
        <label class="block text-sm font-bold {{ $error_message ? 'text-red-400' : 'text-secondary' }} {{ $variant === 'row' ? 'w-1/3' : '' }}">{{ $label }}</label>
    @endif

    <div class="h-full flex {{ $variant === 'row' ? 'w-2/3' : 'w-full' }} {{ $withBorder ? 'border-b-2 '. ($error_message ? 'border-b-red-400' : 'border-b-gray-800') : '' }}   {{ $error_message ? 'border-b-red-400' : 'border-b-gray-800' }}"  x-on:click="{{ $withDropdown ? 'showDropdown = !showDropdown' : 'return' }}">
        <div class="flex flex-wrap gap-2 items-center {{ $withBorder ? 'py-1' : 'py-2' }} min-h-12">
            @if( $selected )
                @foreach( $selected as $key => $value )
                    <span class="bg-school_primary text-sm text-white font-semibold px-3 py-1  whitespace-nowrap flex items-center gap-2 {{ $badge_style == 'pill' ? 'rounded-l-full rounded-r-full' : 'rounded' }}">
                        {{ $value }}
                        @if($withSelectedAction)
                            <span class="rounded-full w-4 h-4 cursor-pointer" wire:click.stop wire:click="handleSelectedAction( {{ $key }} )" >
                                <x-heroicon-s-information-circle />
                            </span>
                        @endif
                        @if($withRemove)
                            <span class="rounded-full w-4 h-4 cursor-pointer" wire:click.stop wire:click="handleRemoveOption( {{ $key }} )" >
                                <x-heroicon-s-x-mark />
                            </span>
                        @endif
                    </span>
                @endforeach
            @endif
        </div>
{{--        <div class="border-l border-l-gray-200">--}}
{{--            <button class="p-3 flex justify-center items-center h-full">--}}
{{--                <x-heroicon-o-chevron-down class="w-4 h-4" />--}}
{{--            </button>--}}
{{--        </div>--}}
    </div>
    <div x-show="showDropdown" x-on:click.away="showDropdown = ! showDropdown"
         class="absolute top-full w-full left-0 bg-white border border-gray-300 rounded-b-lg z-20 -translate-y-[1px] shadow"
        x-cloak>
        @if( $withSearch )
            <div class="flex gap-2 items-center px-6 py-4">
                <x-input.outline wire:model.live="search_value" id="multiselect_search" name="multiselect_search" type="text" placeholder="Search" />
                @if( $this->search_value !== '' && $create_new && count( $options ) == 0 )
                    <x-buttons.secondary wire:click="handleCreateNew()">Add</x-buttons.secondary>
                @endif
            </div>
        @endif

        <div class="divide-y divide-gray-100 px-6 py-4">
            @if( $options )
                @foreach( $options as $id => $option )
                    <p class="text-md font-semibold p-2 cursor-pointer hover:bg-gray-100 transition-all {{ in_array( $id, $options ) ? 'bg-gray-50' : '' }}" :class="$wire.selected.hasOwnProperty('{{ $id }}') ? 'bg-gray-100' : ''" wire:click="handleSelectOption( '{{ $id }}' )">{{ $option }}</p>
                @endforeach
            @else
                <x-notifications.notice>No Options Found</x-notifications.notice>
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
