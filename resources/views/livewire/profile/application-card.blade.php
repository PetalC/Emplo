<div
    x-data="{ isSelected: $wire.entangle('selected').live }"
    class="lg:grid col-span-12 lg:grid-cols-subgrid border py-10 px-4 flex flex-col lg:p-4 rounded-lg border-gray-500 bg-white"
>

    <div class="lg:col-span-1 justify-self-center">
        <x-app.school.avatar :campus="$job->campus" class="w-16 h-16"/>
    </div>

    <div class="lg:col-span-3 gap-2 flex flex-col">
        <p class="text-2xl text-app lg:text-left text-center">
            <a href="{{ route( 'job', $job ) }}">{{ $job->title }}</a>
        </p>

        @if( $job->salary_min > 0 )
            <div class="flex items-center gap-2 text-2xl text-primary">
                <div>${{ number_format($job->salary_min) }}</div>
                <span>-</span>
                <div>${{ number_format($job->salary_max) }}</div>
            </div>
        @endif

        <div><a href="{{ route( 'schools.view', $job->campus ) }}">{{ $job->campus->primary_profile?->name ?? $job->school->name }}</a></div>

        <div>{{ $job->campus->primary_profile?->short_address ?? '' }}</div>

    </div>

    <div class="lg:col-span-8 lg:flex-grow w-full">
        <div class="flex lg:flex-row flex-col items-center justify-between">

            <x-app.job.specifications :job=$job></x-app.job.specifications>

            <div class="flex lg:flex-row flex-col items-center gap-10 lg:mt-0 mt-5">
                <div class="flex items-center gap-10 w-full md:w-auto justify-between">
                    <div class="flex items-center gap-2">
                        <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
                        <span class="whitespace-nowrap">{{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    <livewire:job.bookmark :key="'job_bookmark_' . $job->id" :job="$job" />
                    {{--                        <x-app.job.bookmark url="{{ route('job', $job) }}" title="Employo - {{ $job->title }}" :job="$job" />--}}
                    <x-app.common.share url="{{ route('job', $job) }}" />
                </div>
                <x-buttons.secondary :shadow="false" class="whitespace-nowrap" wire:click="withdraw_application()">Withdraw</x-buttons.secondary>
            </div>

        </div>

        <div class="text-app flex lg:flex-row flex-col items-center lg:gap-20 gap-5 mt-5">
            <x-app.job-center.progress-bar :job="$job" class="w-full lg:w-1/2"/>
        </div>

        <div class="text-app flex lg:flex-row flex-col items-center lg:gap-20 gap-5 mt-5">
            <span>Commencing {{ $job->start_date?->format( 'M Y' ) ?? '' }}</span>
        </div>

        <div class="text-app flex lg:flex-row flex-col items-center lg:gap-20 gap-5 mt-5">
            @php
                $description = $job->description;
                $description = strip_tags($description);
                $description = substr($description, 0, 240 ) . '...';
            @endphp

            <p class="text-gray-400">{{ $description }}</p>
        </div>

    </div>
</div>
