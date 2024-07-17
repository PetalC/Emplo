{{-- badges --}}
<div class="flex gap-1">
    @if($job->isRecommended())
        <x-badge variant="success">Recommended</x-badge>
    @endif
    @if($job->isNearUser())
        <x-badge variant="warning">Near you</x-badge>
    @endif
    @if($job->startingSoon())
        <x-badge variant="error">Starting soon</x-badge>
    @endif
    @if($job->job_length()->exists())
        <x-badge variant="info">{{ $job->job_length->name }}</x-badge>
    @endif
    @if($job->offers_relocation)
        <x-badge variant="info">Offers Relocation</x-badge>
    @endif
    @if($job->offers_housing)
        <x-badge variant="info">Offers Housing</x-badge>
    @endif
{{--    @if($job->isOngoing())--}}
{{--    <x-badge variant="info">Ongoing</x-badge>--}}
{{--    @endif--}}
</div>
