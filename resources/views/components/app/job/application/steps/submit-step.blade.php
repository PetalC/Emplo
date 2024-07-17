@props([ 'job', 'application_id' ])
<div class="flex flex-col w-full py-20">
    <h3 class="py-10">Your supporting documents for <span class="font-bold">{{ $job->school->name }}</span>.</h3>
    <x-app.job.application.review.status :application_id="$application_id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::RESUME" />
    <x-app.job.application.review.status :application_id="$application_id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::COVER_LETTER" />
    <x-app.job.application.review.status :application_id="$application_id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::SCHOOL_APPLICATION_FORM" />
    <x-app.job.application.review.status :application_id="$application_id" :job="$job" :type="\App\Enums\ApplicationReviewStatuses::REFERREES" />
</div>

