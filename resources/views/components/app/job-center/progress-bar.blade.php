@props([
    'job'
])

@php

    /**
     * Advertised
     * Shortlisted
     * Interviewed
     * Approved
     * @var \App\Models\Job $job
     */
    if( $job->applications()->where('status', \App\Enums\ApplicationStatuses::STATUS_HIRED )->exists() ) {
        $val = 100;
        $text = 'Hired';
    } elseif( $job->applications()->where('status', \App\Enums\ApplicationStatuses::STATUS_PENDING )->exists() ) {
        $val = 75;
        $text = 'Interview Pending';
    } elseif ( $job->applications()->where('status', \App\Enums\ApplicationStatuses::STATUS_SHORTLISTED )->exists() ){
        $val = 50;
        $text = 'Shortlisted';
    } else {
        $val = 25;
        $text = 'Advertised';
    }

@endphp
<div class="w-full flex items-center gap-2">
    <div {{ $attributes->merge(['class' => 'bg-gray-200 rounded-lg']) }}>
        <div class="bg-primary h-8 rounded-lg"  :style="'width: ' + {{ $val }} + '%;'"></div>
    </div>
    <p class="text-app ml-5">{{ $text }}</p>
</div>

