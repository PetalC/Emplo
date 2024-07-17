@props([
    'campus_profile',
])
<x-app.common.page_header>

    <x-slot:column_left>
        <x-app.school.avatar class="max-w-44" :campus="$campus_profile->campus" />
        {{ $column_left ?? '' }}
    </x-slot:column_left>

    <x-slot:column_right>
        <div class="mt-16 gap-5 items-center text-gray-500 flex justify-end">
            {{--                <x-app.job.bookmark class="lg:flex hidden" :job="$job" />--}}
            <x-app.common.share url="{{ route('schools.view', $campus_profile->campus ) }}" />
        </div>
        {{ $column_right ?? '' }}
    </x-slot:column_right>

    <x-text.heading class="text-center text-gray-700" variant="h1">{!! \App\Helpers\Strings::wrapLastWord( $campus_profile->name ) !!}</x-text.heading>
    <x-text.subheading class="mt-6">{{ $campus_profile->full_address }}</x-text.subheading>

</x-app.common.page_header>
