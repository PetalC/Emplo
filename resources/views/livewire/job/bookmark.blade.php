<div
    x-data="{ bookmarked: @entangle( 'is_bookmarked' ).live }"
    class="items-center gap-2 flex cursor-pointer"
    @click.stop="bookmarked = !bookmarked"
>
    <x-icon name="heroicon-o-bookmark" class="w-6 h-6" x-bind:class="bookmarked ? 'text-school_primary fill-school_primary' : 'text-gray-300'" />
    <span>Bookmark</span>
</div>
