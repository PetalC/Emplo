@props([
    'type',
    'job',
    'application_id',
])
@php
$title = 'N/A';
$statusOn = false;
$application = \App\Models\Application::find($application_id);

switch ($type) {
    case \App\Enums\ApplicationReviewStatuses::RESUME:
        $title = 'Uploaded Resume';
        $statusOn = $application->hasMedia(\App\Enums\MediaCollections::APPLICATION_DOCUMENTS->value);
        break;
    case \App\Enums\ApplicationReviewStatuses::COVER_LETTER:
        $title = 'Uploaded Cover Letter';
        $statusOn = $application->hasMedia(\App\Enums\MediaCollections::APPLICATION_DOCUMENTS->value);
        break;
    case \App\Enums\ApplicationReviewStatuses::SCHOOL_APPLICATION_FORM:
        $title = $job->school->name .' School Application Form';
        $statusOn = $application->hasMedia(\App\Enums\MediaCollections::APPLICATION_DOCUMENTS->value);
        break;
    case \App\Enums\ApplicationReviewStatuses::REFERREES:
        $title = 'Referee Details';
        $statusOn = $application->reference_checks->count() > 0;
        break;
}
@endphp
<div class="flex flex-row mx-10 py-12 border-t-2 border-b-2 border-gray-100 gap-5">
    @if($statusOn)
        <x-icon name="heroicon-c-check-circle" class="w-6 h-6 text-primary cursor-pointer" />
    @else
        <x-icon name="heroicon-c-minus-circle" class="w-6 h-6 text-gray-300 cursor-pointer" />
    @endif
    <h3 class="font-bold">{{ $title }}</h3>
</div>
