<div>
    @if( $isFollowing )
        <div wire:click.stop="unfollow">
            <x-dynamic-component :component="'buttons.' . $alt_button_variant" class="{{ $button_class }} whitespace-nowrap" :shadow="$shadow">Unfollow School</x-dynamic-component>
{{--            <x-buttons.{{ $button_variant }} class="!text-[10px] !px-3 !py-0.5 mt-2" :shadow="false">Unfollow School</x-buttons.{{ $button_variant }}>--}}
        </div>
    @else
        <div wire:click.stop="follow">
            <x-dynamic-component :component="'buttons.' . $button_variant" class="{{ $button_class }} whitespace-nowrap" :shadow="$shadow">Follow School</x-dynamic-component>
        </div>
    @endif
</div>
