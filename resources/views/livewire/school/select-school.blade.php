<div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 max-w-8xl mx-auto pb-10 px-10 lg:px-0">
        @foreach( $schools as $school )
            <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center gap-6 border border-gray-100 min-h-[400px]">
                <x-app.school.avatar :school="$school" class="mx-auto max-w-80" />
{{--                <img src="{{ $school->getLogo() }}" alt="{{ $school->name }}" class="w-32 h-32 object-cover mx-auto rounded-full">--}}
                <h2 class="text-xl font-bold text-gray-800 text-center min-h-[60px]">{{ $school->name }}</h2>
{{--                <p class="text-gray-600">{{ $school->address }}</p>--}}
                <div class="mt-4">
                    <x-buttons.primary :shadow="false" size="lg" wire:click="selectSchool( {{ $school->id  }} )" >Manage School</x-buttons.primary>
                </div>
            </div>
        @endforeach
    </div>

</div>
