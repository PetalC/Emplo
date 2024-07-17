@props([
    'user' => Auth::user(),
])

<div class="max-w-5xl mx-auto text-app font-app text-xl font-light leading-relaxed mt-16 mb-20">

    <p class="font-bold mb-6">Basic Information</p>

    <ul class="list-disc pl-4">
{{--        <li>--}}
{{--            I am currently:--}}
{{--        </li>--}}
        <li>
            I am currently working in/as at a: <span class="text-blue-600">{{ $user->current_position_types->pluck( 'name' )->join( ', ' ) }}</span>
        </li>
{{--        <li>--}}
{{--            I am seeking a role as/or in:--}}
{{--        </li>--}}
        <li>
            My preferred job types are: <span class="text-blue-600">{{ $user->subjects->pluck( 'name' )->join( ', ' ) }}</span>
        </li>
        <li>
            My preferred job length is: <span class="text-blue-600">{{ $user->preferred_job_lengths->pluck( 'name' )->join( ', ' ) }}</span>
        </li>
        <li>
            I am: <span class="text-blue-600">currently licenced to work in an Australian school</span>
        </li>
        <li>
            I hold an <span class="text-blue-600">{{ $user->profile->citizenship?->name ?? 'Unknown' }}</span>
        </li>
        <li>
            My preferred school types are: <span class="text-blue-600">{{ $user->preferred_school_types->pluck( 'name' )->join( ', ' ) }}</span>
        </li>
        <li>
            I <span class="text-blue-600">{{ $user->profile->faith_reference ? 'can' : 'cannot' }} supply a faith reference</span>
        </li>
    </ul>

</div>
