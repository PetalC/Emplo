@props([
    'job',
    'description_variant' => 1,
    'is_ats' => false
])
<div class="block mx-auto max-w-8xl" >

    <div class="grid grid-cols-1 lg:grid-cols-12">

        <div class="col-span-2 flex flex-col items-start -translate-y-10">

            <x-app.school.avatar url="{{ route( 'schools.view', $job->campus ) }}" class="max-w-44" :campus="$job->campus" />

            {{ $column_left ?? '' }}

        </div>

        <div class="col-span-8 flex flex-col gap-12 items-center pt-10 px-6 lg:px-0 ">

            <x-text.heading class="text-center text-gray-700 leading-normal lg:leading-none" variant="h1">{!! \App\Helpers\Strings::wrapLastWord( $job->title ) !!}</x-text.heading>

            @if (!$is_ats)
            <div class="flex justify-center flex-col items-center text-gray-500 gap-5">
                <p class="text-3xl text-center"><a class="underline" href="{{ route( 'schools.view', $job->campus ) }}">{{ $job->campus->primary_profile?->name ?? '' }}</a></p>
                <p class="text-center">{{ $job->campus->primary_profile?->full_address ?? '' }}</p>
{{--                <p>Archer Street, Rockhampton, QLD, Australia 12km away, <span class="font-bold underline text-blue-700">map your commute</span> </p>--}}
            </div>
            @endif

            <div class="flex flex-col xl:flex-row justify-center gap-8 items-center text-gray-500">
                <h3 class="text-4xl text-primary text-center">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</h3>
                <x-app.job.specifications :job=$job />
                <x-app.job.posted-date :job=$job />
            </div>

            @if( $description_variant == 1 )
                <p class="text-center text-gray-600">
                    <x-app.job.start-date :job=$job />
                </p>
            @else
                <div class="text-center">
                    <x-app.job.start-date :job=$job />
                </div>
            @endif

{{--            <x-text.subheading class="mt-6">{{ $job->campus->primary_profile->full_address }}</x-text.subheading>--}}

            {{ $slot }}

        </div>

        <div class="col-span-2">

            {{ $column_right ?? '' }}

        </div>

    </div>

</div>


{{--<div class="block mx-auto max-w-8xl" >--}}

{{--    --}}{{-- logo --}}
{{--    <x-app.school.responsive-header showDropdownMenu="{{ false }}">--}}
{{--        <div>--}}
{{--            {{ $column_left ?? '' }}--}}
{{--        </div>--}}

{{--        <x-button.outline  fullWidth>School Profile</x-button.outline>--}}
{{--        <x-button.outline  fullWidth>Follow</x-button.outline>--}}
{{--        <div class="text-gray-500 flex w-full px-3 justify-between">--}}
{{--            <x-icon name="heroicon-o-arrow-left" class="w-5 h-5" />--}}
{{--            Return to search results--}}
{{--        </div>--}}
{{--    </x-app.school.responsive-header>--}}

{{--    <div class="max-w-4xl mx-auto px-20 lg:px-0">--}}
{{--        <x-text.heading class="pt-10 text-center text-gray-700 leading-[60px]" variant="h1">{{ $job->title }}</x-text.heading>--}}
{{--        <div class="flex justify-center flex-col items-center text-gray-500 gap-5 mt-12">--}}
{{--            <p class="text-3xl">Working at <span class="underline">{{ $job->school->name }}</span></p>--}}
{{--            <p>Archer Street, Rockhampton, QLD, Australia 12km away, <span class="font-bold underline text-blue-700">map your commute</span> </p>--}}
{{--        </div>--}}
{{--        {{ $slot }}--}}
{{--        <div class="flex flex-col xl:flex-row justify-center gap-8 items-center mt-12 text-gray-500">--}}
{{--            <h3 class="text-4xl text-primary text-center">${{ number_format($job->salary_min) }}</h3>--}}
{{--            <x-app.job.specifications :job=$job />--}}
{{--            <x-app.job.posted-date :job=$job />--}}
{{--        </div>--}}

{{--        @if( $description_variant == 1 )--}}
{{--            <p class="text-center mt-12 text-gray-600">--}}
{{--                <x-app.job.start-date :job=$job />--}}
{{--            </p>--}}
{{--        @else--}}
{{--            <div class="text-center mt-12">--}}
{{--                <x-app.job.start-date :job=$job />--}}
{{--            </div>--}}
{{--        @endif--}}

{{--    </div>--}}

{{--    <div class="flex flex-col items-center xl:absolute top-0 right-20">--}}
{{--        {{ $column_right ?? '' }}--}}
{{--    </div>--}}

{{--</div>--}}
