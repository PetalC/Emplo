@props([
    'campus_profile'
])
<div class="bg-gray-50 border-t-school_primary border-gray-800 p-12" id="available_positions">

    <h3 class="text-4xl text-center mb-12">Available <span class="text-school_primary">Positions</span></h3>

    <div class="flex flex-col gap-8 max-w-7xl mx-auto">
        @foreach( $campus_profile->campus->latest_jobs as $job )
            <livewire:search.job-card :key="$job->id" :job="$job" />
        @endforeach
    </div>

</div>
