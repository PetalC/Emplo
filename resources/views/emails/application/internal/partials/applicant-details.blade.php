Applicant Details
<div class="grid-cols-2">
    <div>
        <span>Name</span>
        <span>{{ $application->user->name }}</span>
    </div>
    <div>
        <span>Email</span>
        <span>{{ $application->user->email }}</span>
    </div>
    @if ($application->user->profile)
    <div>
        <span>State</span>
        <span>{{ $application->user->profile->state }}</span>
    </div>
    <div>
        <span>Profile</span>
        <span>{{ $application->user->getProfileUrl }}</span>
    </div>
    @endif
</div>
