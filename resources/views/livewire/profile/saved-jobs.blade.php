<div>
    <div class="flex flex-col gap-8 mb-8 mt-4 px-5 4xl:px-0" wire:loading.class="opacity-25">
        @forelse($jobs as $job)
            <livewire:search.job-card :key="'job_' . $job->id" :job="$job" />
        @empty
            <div class="flex flex-col pb-20 text-gray-600 gap-20 p-5 items-center">
                <h3 class="text-4xl font-light text-center">
                    You do not have any saved jobs. Please <a href="{{ route('search') }}" class="text-primary">search for jobs</a> to save them.
                </h3>
            </div>
        @endforelse
    </div>
</div>

