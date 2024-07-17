<x-public-layout :campus="$campus">

    <x-app.school.public.page_header :campus_profile="$campus_profile">
        <x-slot name="column_left">
            <div class="w-full max-w-44" x-data="{}">
                <livewire:components.campus.follow-campus-button button_class="text-lg justify-center py-3 w-full font-normal mt-4" class="" :campus="$campus_profile->campus" />
                <x-buttons.secondary class="text-lg justify-center py-3 w-full font-normal mt-4" @click.stop="smoothScrollTo( document.getElementById('available_positions').offsetTop - 150, 1000 )">Jobs</x-buttons.secondary>
            </div>
        </x-slot>
        <x-slot name="column_right">

        </x-slot>
    </x-app.school.public.page_header>

    <x-app.school.public.profile_header :with_header="false"  :campus_profile="$campus_profile" />

    {{-- icons --}}
    <div class="overflow-auto">
        <x-app.school.public.info_badges :campus_profile="$campus_profile"/>
    </div>

    <x-app.school.public.about :campus_profile="$campus_profile" />

    <x-app.school.public.available_jobs :campus_profile="$campus_profile" />

    <x-app.school.public.map :campus_profile="$campus_profile" />

</x-public-layout>
