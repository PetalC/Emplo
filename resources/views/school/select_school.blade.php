<x-dashboard-layout>

    <x-text.heading class="text-center text-gray-700 py-10" variant="h1">
        Select Your <span class="text-school_primary">School</span>
    </x-text.heading>

{{--    <div class="flex justify-between">--}}
{{--        <div>--}}
{{--            --}}{{--            {{ sprintf( __('%s Campuses'), count( $campuses ) ) }}--}}
{{--        </div>--}}
{{--    </div>--}}

    <livewire:school.select-school />

</x-dashboard-layout>
