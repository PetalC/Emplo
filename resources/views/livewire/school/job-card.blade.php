

<div class="cursor-pointer flex lg:gap-0 gap-5 items-start p-5 rounded-lg rounded-0 bg-white border border-gray-300 hover:drop-shadow-md transition text-gray-700 lg:flex-row flex-col lg:m-0 m-4"
    href="{{ route('school.applicants.view', [$job] ) }}" wire:navigate>
    {{-- detail --}}
    <div class="flex gap-5 flex-grow lg:ml-5 lg:w-2/3">
        <h2>{{ $job->title }}</h2>
        <div class="flex flex-col">
            <div class="flex w-full lg:items-center justify-between lg:flex-row flex-col">
                <x-app.job.specifications :job=$job></x-app.job.specifications>

                <span class="mt-4 lg:hidden leading-none">Commencing March 2024</span>

                <p class="mt-2 text-gray-400 lg:hidden">{{ substr($job->description, 0, 500) . '...' }}</p>
                {{-- other stuff - posted date and bookmark --}}
                <div class="flex lg:flex-row flex-col items-center gap-4 lg:mt-0 mt-5">
                    <div class="flex items-center gap-4 w-full md:w-auto justify-between">
                        <div class="flex items-center gap-2">
                            <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
                            <span class="whitespace-nowrap">{{ (new \Moment\Moment($job->created_at->toDateString()))->fromNow()->getRelative() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
