<div>

    <x-text.heading class="text-center text-gray-700 py-10" variant="h1">
        Select Your <span class="text-school_primary">Campus</span>
    </x-text.heading>

{{--    <x-text.dashboard.page_title class="py-10">--}}
{{--        --}}
{{--    </x-text.dashboard.page_title>--}}

    <div class="px-4 max-w-8xl mx-auto">

{{--        <div class="flex justify-between">--}}
{{--            <div>--}}
{{--                {{ sprintf( __('%s Campuses'), count( $campuses ) ) }}--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 pb-10 justify-center">

            @foreach( $campuses as $campus )
                <div class="bg-white border border-gray-200 rounded-lg p-4 my-4 flex flex-col gap-6 items-center self-center min-h-[400px]">
                    <x-app.school.avatar :campus="$campus" />
                    <h2 class="text-xl font-bold text-gray-800 min-h-[60px]">{{ $campus->primary_profile?->name ?? $campus->school->name }}</h2>
                    @if( $campus->primary_profile )
                        <p class="text-gray-600 min-h-[60px]">{{ $campus->primary_profile->short_address }}</p>
                    @endif
                    <div>
                        <x-buttons.primary wire:click="selectCampus( {{ $campus->id }} )">Select Campus</x-buttons.primary>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</div>
