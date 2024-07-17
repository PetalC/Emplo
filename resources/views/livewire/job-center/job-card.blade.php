<div
    x-data="{ isSelected: $wire.entangle('selected').live }"
    :class="isSelected ? 'border-green-600 bg-green-50' : 'border-gray-500 bg-white'"
    class="lg:grid col-span-12 lg:grid-cols-subgrid border py-10 px-4 flex flex-col gap-10 items-center lg:p-4 rounded-lg overflow-hidden"
>

    <div class="lg:col-span-1 justify-self-center">
        <x-input.checkbox id="job_selected_{{ $job->id }}" name="job_selected_{{ $job->id }}" x-model="isSelected" class="w-8 h-8 rounded-lg"/>
    </div>

    <div class="lg:col-span-3 gap-2 flex flex-col">
        <p class="text-2xl text-app lg:text-left text-center">
            <a href="{{ route( 'school.jobcenter.edit', $job ) }}">{{ $job->title }}</a>
        </p>
        <p class="text-primary text-xl lg:text-left text-center">${{ number_format( $job->salary_min ) }}</p>
    </div>

    <div class="lg:col-span-8 lg:flex-grow w-full">
        <div class="flex lg:flex-row flex-col items-center justify-between">
            <div class="flex lg:flex-row flex-col lg:w-6/12 w-full items-center lg:gap-0 gap-2">
                <x-app.job-center.progress-bar :job="$job" class="w-full"/>
            </div>
            <div class="flex gap-2">
                @if( $job->url_slug )
                    <x-buttons.secondary :shadow="false" target="_blank" elem_type="link" href="{{ route( 'job', [ $job ] ) }}" class="lg:w-fit w-full lg:block hidden">View Job Ad</x-buttons.secondary>
                @endif
{{--                <x-button.outline class="lg:w-fit w-full lg:block hidden">View Job Ad</x-button.outline>--}}
                @if( $job->status == \App\Enums\JobStatus::OPEN )
                    <x-buttons.primary elem_type="link" href="{{ route( 'school.applicants.view', $job ) }}" :shadow="false" elem_type="link" class="lg:w-fit w-full lg:block hidden">Manage Candidates</x-buttons.primary>
                @endif
            </div>
        </div>
        <div class="text-app flex lg:flex-row flex-col items-center lg:gap-20 gap-5 mt-5">
            <div class="flex justify-between w-full">
                <div class="flex">
                    <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
                    <span class="ml-2">{{ $job->created_at->diffForHumans() }}</span>
                </div>

                <span class="ml-2">Commencing {{ $job->start_date?->format( 'M Y' ) ?? '' }}</span>

                @if( $job->status == \App\Enums\JobStatus::OPEN )
                    <div class="flex gap-2 text-app">
                        <x-icon name="heroicon-o-user" class="w-5 h-5"/>
                        <p><span class="text-primary font-bold">{{ $job->candidate_statistics['shortlisted'] }}</span> shortlisted, </p>
                        <p><span>{{ $job->candidate_statistics['total_applications'] }}</span> Applied</p>
                    </div>
                    <div class="flex gap-2 text-app">
                        <x-icons.speech />
                        <p><span class="text-primary font-bold">{{ $job->candidate_statistics['scheduled_interviews'] }}</span> Upcoming interviews</p>
                    </div>
                @endif

            </div>

            @if( $job->url_slug )
                <x-buttons.secondary :shadow="false" target="_blank" elem_type="link" href="{{ route( 'job', $job ) }}" class="lg:w-fit w-full lg:hidden block whitespace-nowrap">View Job Ad</x-buttons.secondary>
            @endif
            @if( $job->status == \App\Enums\JobStatus::OPEN )
                <x-buttons.primary href="{{ route( 'school.applicants.view', $job ) }}" class="lg:w-fit w-full lg:hidden bloc whitespace-nowrap">Manage Candidates</x-buttons.primary>
            @endif
        </div>
    </div>
</div>
