<div class="flex flex-col w-full ">
    <h3 class="py-10 text-center mb-6 text-xl font-light">Your supporting documents for <span class="font-bold">{{ $job->name }}</span> at {{ $job->campus->primary_profile?->name }}.</h3>

    @foreach( $rows as $row )
    <div class="divide-y divide-gray-200">
        <div class="flex flex-row mx-10 py-12 border-t-2 border-b-2 border-gray-100 gap-5">
            @if($row['is_ticked'])
                <x-icon name="heroicon-c-check-circle" class="w-6 h-6 text-primary cursor-pointer" />
            @else
                <x-icon name="heroicon-c-minus-circle" class="w-6 h-6 text-gray-300 cursor-pointer" />
            @endif
            <h3 class="font-bold">{{ $row['name'] }}</h3>
        </div>
    </div>
    @endforeach

    <div>
        <div class="flex justify-center gap-4 mt-10">
            <x-buttons.secondary size="xl" wire:click="$parent.previousStep()">Documents</x-buttons.secondary>
            {{--            <x-buttons.secondary wire:click="$parent.previousStep()">Back</x-buttons.secondary>--}}
            @if( in_array( $this->application?->validated_step, [ 'documents' ] ) )
                <x-buttons.primary :shadow="false" size="xl" wire:click="submitApplication">Submit Application</x-buttons.primary>
            @endif
        </div>
    </div>

{{--    <x-app.job.application.review.status :application_id="$application->id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::RESUME" />--}}
{{--    <x-app.job.application.review.status :application_id="$application->id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::COVER_LETTER" />--}}
{{--    <x-app.job.application.review.status :application_id="$application->id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::SCHOOL_APPLICATION_FORM" />--}}
{{--    <x-app.job.application.review.status :application_id="$application->id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::REFERREES" />--}}
</div>
