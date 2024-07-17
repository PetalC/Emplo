<x-dashboard-layout>

    <x-text.dashboard.page_title>
        {{ __('Campus Profiles') }}
    </x-text.dashboard.page_title>

    <div class="px-4">

        <div class="flex justify-between items-center">
            <div>
                {{ sprintf( __('%s Profiles'), count( $profiles ) ) }}
            </div>
            <div>
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.campus.create_profile', [ 'campus' => $campus ] ) }}">
                    {{ __('Create Profile') }}
                </x-buttons.secondary>
            </div>
        </div>

        <div>

            @foreach( $profiles as $profile )
                <div class="bg-white border border-gray-200 rounded-lg p-4 my-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $profile->name }}</h2>
                    <div class="mt-4">
                        <a href="{{ route('school.campus_profile', [ 'campus' => $campus->id, 'profile' => $profile ]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Manage Campus Profile</a>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</x-dashboard-layout>
