{{-- This component is not just on the search page. This is used in --}}
{{-- -- Search Page --}}
{{-- -- Candidates Page --}}
{{-- -- User Saved Jobs Page --}}
<div id="result_{{ $job->id }}"
    class="items-start p-5 m-4 text-gray-700 transition bg-white border border-gray-300 rounded-lg cursor-pointer xl:grid xl:grid-cols-12 rounded-0 hover:drop-shadow-md lg:m-0 overflow-hidden"
    @click="window.location = '{{ route('job', $job) }}'"
    style="--school-primary-color: {{ $job->campus?->primary_profile->branding_primary_color ?? '#0ea5e9' }}">
    <div class="col-span-4">
        <div class="flex flex-col items-center gap-8 pr-2 md:items-start md:flex-row">
            <div class="flex flex-col items-center">
                <x-app.school.avatar class="w-[80px] mb-2 !p-3 box-border" img_class="" :campus="$job->campus" />
                <livewire:components.campus.follow-campus-button :campus="$job->campus" />
            </div>
            <div>
                <h5 class="text-[28px] leading-[1.3em]">{{ $job->title }}</h5>
                @if ($job->salary_min > 0)
                    <div class="flex items-center gap-2 mt-2 text-2xl text-primary">
                        <div>${{ number_format($job->salary_min) }}</div>
                        <span>-</span>
                        <div>${{ number_format($job->salary_max) }}</div>
                    </div>
                @endif
                <div class="mt-4"><a
                        href="{{ route('schools.view', $job->campus) }}">{{ $job->campus->primary_profile?->name ?? $job->school->name }}</a>
                </div>
                <div class="mt-1">{{ $job->campus->primary_profile?->short_address ?? '' }}</div>
            </div>
        </div>
    </div>

    <div class="col-span-8 pt-12 xl:pt-0">
        <div class="flex flex-col">
            <div class="flex flex-col justify-between w-full lg:items-center lg:flex-row">
                <x-app.job.specifications :job=$job></x-app.job.specifications>

                <span class="mt-4 leading-none lg:hidden">Commencing {{ $job->start_date?->format('F Y') }}</span>

                <p class="mt-2 text-gray-400 lg:hidden">{{ substr($job->description, 0, 240) . '...' }}</p>

                <div class="flex flex-col items-center gap-10 mt-5 lg:flex-row lg:mt-0">
                    <div class="flex flex-col items-start justify-between gap-2 sm:flex-row sm:items-center md:gap-10">
                        <div class="flex items-center gap-2">
                            <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
                            <span class="whitespace-nowrap">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                        <livewire:job.bookmark :key="'job_bookmark_' . $job->id" :job="$job" />
                        <x-app.common.share url="{{ route('job', $job) }}" />
                    </div>
                    <x-app.job.apply-button type="secondary" :job="$job" />
                </div>

            </div>

            <span class="hidden mt-4 lg:block">Commencing {{ $job->start_date?->format('F Y') }}</span>

            @php
                $description = $job->description;
                $description = strip_tags($description);
                $description = substr($description, 0, 240) . '...';
            @endphp

            <p class="hidden mt-2 text-gray-400 lg:block">{{ $description }}</p>

        </div>
    </div>

    {{-- job application modal --}}
    {{-- <x-app.job.application-modal>Test</x-app.job.application-modal> --}}

</div>
