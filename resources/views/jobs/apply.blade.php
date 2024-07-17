<x-public-layout :campus="$job->campus">

    <x-app.job.page-header :job="$job" description_variant="1">
        </x-app.job.page-header>
    <div class="max-w-7xl mx-auto pt-6">

{{--        <x-text.heading class="!text-4xl text-center my-6" variant="h3">Job Application</x-text.heading>--}}

        <livewire:job.apply :job="$job" />
{{--        @switch( $current_component )--}}
{{--            @case( 'user-details' )--}}
{{--                <livewire:job.application.user-details :application="$application" />--}}
{{--                @break--}}
{{--            @case( 'documents' )--}}
{{--                <livewire:job.application.documents :application="$application" />--}}
{{--                @break--}}
{{--            @case( 'reviews' )--}}
{{--                <livewire:job.application.review :application="$application" />--}}
{{--                @break--}}
{{--            @case( 'complete' )--}}
{{--                <livewire:job.application.complete :application="$application" />--}}
{{--                @break--}}
{{--        @endswitch--}}

{{--        <livewire:job.application.stepper :job=$job />--}}

    </div>

</x-public-layout>
