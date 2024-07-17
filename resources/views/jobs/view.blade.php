<x-public-layout :campus="$job->campus">
    <x-app.job.page-header :job="$job" description_variant="2">
        <x-slot name="column_left">
            <div class="w-full max-w-44" x-data="{}">
                <livewire:components.campus.follow-campus-button button_class="text-lg justify-center py-3 w-full font-normal mt-4" class="" :campus="$job->campus" />
{{--                <x-buttons.secondary class="text-lg justify-center py-3 w-full font-normal mt-4" @click.stop="smoothScrollTo( document.getElementById('available_positions').offsetTop - 150, 1000 )">Jobs</x-buttons.secondary>--}}
            </div>
        </x-slot>
        <x-slot name="column_right">
            <div class="mt-16 flex gap-5 items-center text-gray-500 lg:w-fit w-full px-20">
                <x-app.common.share url="{{ route('job', $job ) }}" />
                <x-app.job.apply-button :job=$job :type="'primary'" class="w-full lg:w-fit"/>
            </div>
        </x-slot>
    </x-app.job.page-header>

    {{-- About Job --}}
    <div class="w-full my-10 px-10 max-w-6xl mx-auto text-app leading-7 flex flex-col gap-10">
        <div>
            {!! nl2br($job->description) !!}
        </div>
        <div>
            <p class="text-3xl font-light mb-6">Key duties and responsibilities</p>
            {!! $job->responsibilities !!}
        </div>
{{--        <div>--}}
{{--            <p class="text-3xl font-light mb-6">Required licences and certificates</p>--}}
{{--            {!! $job->required_licences_certs !!}--}}
{{--        </div>--}}
        @if($supporting_documents->count() > 0)
            <p class="text-3xl font-light mb-6">Supporting Documents</p>
            <div class="mt-10 flex gap-5 items-center">
                @foreach($supporting_documents as $document)
                    <x-icon name="heroicon-o-document" class="w-5 h-5 text-primary" />
                    <p><a class="underline" href="{{ $document->getUrl() }}" download>{{ $document->name  }}</a></p>
                @endforeach
            </div>
        @endif
        <div class="md:hidden">
            <x-app.job.apply-button :job=$job :type="'primary'" />
        </div>
    </div>

    {{-- horizontal line --}}
    <div class="px-10 lg:px-20">
        <hr class/>
    </div>

    <x-app.school.public.profile_header :campus_profile="$job->campus->primary_profile" />

    {{-- icons --}}
    <div class="overflow-auto">
        <x-app.school.public.info_badges :campus_profile="$job->campus->primary_profile"/>
    </div>

    <x-app.school.public.about :campus_profile="$job->campus->primary_profile" />

    <div class="bg-gradient-to-r from-school_primary to-school_primary 2xl:to-white 2xl:via-school_primary 2xl:to-90% 2xl:via-90% pt-16 pb-12 -mt-6">
        <div class="max-w-8xl mx-auto flex gap-3">
            <p class="text-9xl text-white/55">"</p>
            <div class="xl:pr-[150px]">
                <p class="text-white text-4xl font-light leading-relaxed">{{ $job->campus->primary_profile?->quote }}</p>
{{--                <div class="mt-5 text-xl text-white pr-[150px]">--}}
{{--                    <p class="font-semibold">Gianluca</p>--}}
{{--                    <p>Music Teacher</p>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    @if( $job->campus->primary_profile )
        <x-app.school.public.map :campus_profile="$job->campus->primary_profile" />
    @endif

    {{-- School Map --}}
{{--    <div id="school_map" class="w-full h-[430px]"></div>--}}

    {{-- footer --}}
{{--    <x-dialog class="w-full py-10 flex lg:flex-row flex-col justify-between">--}}
{{--        <x-button.outline  fullWidth class="lg:hidden">School Profile</x-button.outline>--}}
{{--        <x-button.outline  fullWidth class="my-10 lg:hidden">Follow</x-button.outline>--}}
{{--        <div class="flex lg:flex-row flex-col items-center gap-5">--}}
{{--            <img src="{{ asset('assets/app/school-1-logo.png') }}" class="w-12"/>--}}
{{--            <p class="text-3xl text-gray-500">Can we help you with something?</p>--}}
{{--        </div>--}}
{{--        <div class="flex lg:flex-row flex-col items-center gap-5 lg:mt-0 mt-10">--}}
{{--            <x-input.text id="start_chat" name="start_chat" placeholder="Start a chat..." class="w-[450px]"/>--}}
{{--            <x-button.secondary class="lg:w-fit w-full">Message</x-button.secondary>--}}
{{--        </div>--}}
{{--        <div class="flex lg:flex-row flex-col-reverse items-center gap-5 lg:mt-0 mt-10">--}}
{{--            <div class="text-gray-500 lg:hidden flex w-full px-3 justify-center gap-5 mt-10">--}}
{{--                <x-icon name="heroicon-o-arrow-left" class="w-5 h-5" />--}}
{{--                Return to search results--}}
{{--            </div>--}}
{{--            <div class="flex gap-5">--}}
{{--                <x-app.job.bookmark class="flex" :job="$job" />--}}
{{--                <x-icon name="heroicon-o-share" class="w-5 h-5" />--}}
{{--            </div>--}}
{{--            <x-app.job.apply-button :job=$job :type="'primary'" class="lg:w-fit w-full" />--}}
{{--        </div>--}}
{{--    </x-dialog>--}}

{{--    <div class="flex flex-col p-6 gap-10 justify-between items-center text-center md:grid md:grid-cols-7 max-w-8xl mx-auto">--}}
{{--        <div class="flex w-full justify-center md:row-start-1 md:col-start-1 md:flex-col">--}}
{{--            <x-app.school.avatar :school="$job->school" />--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center md:row-start-1 align-text-bottom md:col-start-2 md:col-span-4 md:mt-auto">--}}
{{--            <h1 class="text-6xl text-center">{{ $job->title }}</h1>--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center md:col-start-2 md:col-span-4">--}}
{{--            <h2 class="text-4xl text-center">Working at {{ $job->school->name }}</h2>--}}
{{--            <x-app.school.address :school="$job->school" :map="false" />--}}
{{--            <div class="md:flex md:flex-row md:justify-center md:items-center gap-4">--}}
{{--                <h3 class="text-4xl text-primary text-center">${{ number_format($job->salary_min) }}</h3>--}}
{{--                <x-app.job.specifications :job=$job />--}}
{{--                <x-app.job.posted-date :job=$job />--}}
{{--            </div>--}}
{{--            <x-app.job.start-date :job=$job />--}}
{{--        </div>--}}
{{--        <div class="md:row-start-1 md:col-start-7 md:col-span-1 md:px-6 md:mt-auto">--}}
{{--            <x-app.job.apply-button :job=$job :type="'primary'" />--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:col-start-2 md:col-span-4">--}}
{{--            {{ $job->description }}--}}
{{--            <div class="md:hidden">--}}
{{--                <x-app.job.apply-button :job=$job :type="'primary'" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--            <div class="flex flex-row md:row-start-1 md:col-start-6 md:col-span-1 md:justify-center md:mt-auto">--}}
{{--                <x-app.job.bookmark :job=$job />--}}
{{--                <x-app.job.share :job=$job />--}}
{{--            </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:col-start-2 md:col-span-4">--}}
{{--            <h3>[Testimonial 1]</h3>--}}
{{--            <p>other blurb</p>--}}
{{--            <h3>[Testimonial 2]</h3>--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:col-start-1 md:col-span-7">--}}
{{--            <x-app.school.address :school="$job->school" :map="true" />--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:row-start-2 md:col-start-1 md:col-span-1">--}}
{{--            <x-button.outline href="#" --}}{{-- route('school', ['id' => $job->school->id]) --}}{{-- wire:navigate>School Profile</x-button.outline>--}}
{{--            <x-app.school.follow-button :school="$job->school" />--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:col-start-1 md:col-span-5">--}}
{{--            <x-app.job.school-message ></x-app.job.school-message>--}}
{{--            <hr class="md:hidden" />--}}
{{--        </div>--}}
{{--        <div class="flex flex-col gap-10 justify-center items-center pt-5 md:col-start-6 md:col-span-2 md:flex-row-reverse">--}}
{{--            <x-app.job.apply-button :job=$job :type="'primary'" />--}}
{{--            <div class="flex flex-row">--}}
{{--                <x-app.job.bookmark :job=$job />--}}
{{--                <x-app.job.share :job=$job />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="flex w-4/5 md:row-start-2 md:col-start-1 md:col-span-1">--}}
{{--            <div class="flex flex-row w-full justify-around align-middle" href="{{ url()->previous() }}" wire:navigate>--}}
{{--                <x-icon name="heroicon-o-arrow-left" class="w-6"></x-icon>--}}
{{--                <span>Return to search results</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-public-layout>

{{--<script>--}}
{{--	// TO MAKE THE MAP APPEAR YOU MUST--}}
{{--	// ADD YOUR ACCESS TOKEN FROM--}}
{{--	// https://account.mapbox.com--}}
{{--	mapboxgl.accessToken = '{{ config('mapbox.access_token') }}';--}}
{{--    const map = new mapboxgl.Map({--}}
{{--        container: 'school_map', // container ID--}}
{{--        center: [{{ $job->campus->primary_profile?->longitude ?? 100 }}, {{ $job->campus->primary_profile?->latitude ?? 100 }}], // starting position [lng, lat]--}}
{{--        zoom: 9 // starting zoom--}}
{{--    });--}}
{{--</script>--}}
