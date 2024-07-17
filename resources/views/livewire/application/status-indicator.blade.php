<div class="flex">
    @switch($application->status)
        @case(\App\Enums\ApplicationStatuses::STATUS_SHORTLISTED)
            <x-badge class="!px-2 !py-1 text-xs mt-1" variant="warning">Shortlisted</x-badge>
            @break
        @case(\App\Enums\ApplicationStatuses::STATUS_DECLINED)
            <x-badge class="!px-2 !py-1 text-xs mt-1" variant="error">Declined</x-badge>
            @break
        @case(\App\Enums\ApplicationStatuses::STATUS_PENDING)
            <x-badge class="!px-2 !py-1 text-xs mt-1" variant="success">Pending Interview</x-badge>
            @break
        @case(\App\Enums\ApplicationStatuses::STATUS_HIRED)
            <x-badge class="!px-2 !py-1 text-xs mt-1" variant="success">Hired</x-badge>
            @break
        @case(\App\Enums\ApplicationStatuses::STATUS_SUBMITTED)
            <x-badge class="!px-2 !py-1 text-xs mt-1" variant="success">Submitted</x-badge>
            @break
        @case('PENDING')
        @default
            [{{ $application->status }}]
            @break
    @endswitch
</div>
