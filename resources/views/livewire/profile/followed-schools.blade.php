<div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-8 mb-8 mt-4 px-5 4xl:px-0" wire:loading.class="opacity-25">
        @forelse($campuses as $campus)
            <livewire:search.school-card :key="'campus_' . $campus->id" :campus="$campus" />
        @empty
            <h3 class="text-4xl font-light text-center col-span-5">
                You are not following any schools. Please <a href="{{ route('search', [ 'schools' => true ]) }}" class="text-primary">search for schools</a> to save them.
            </h3>
        @endforelse
    </div>
</div>
