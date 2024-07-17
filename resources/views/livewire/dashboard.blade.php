<div class="max-w-8xl mx-auto flex flex-col text-secondary">

    {{-- job board --}}
    <livewire:job.search.job-board />

    {{-- create your profile --}}
    <div class="flex flex-col pb-20 text-gray-600 gap-20 p-5">
        <x-text.heading variant="h3" class="text-center">
            Create <span class="text-primary">your profile</span>
        </x-text.heading>

        <livewire:dashboard.shortlisted-candidate-card />

        <div class="flex flex-col text-center gap-2">
            <p>This will be the smartest 5 minutes you ever spend. Complete the profile that will act like a universal application as</p>
            <p>our technology will help you automate your search. Hunt for teaching and non-teaching jobs, search for schools</p>
            <p>and access employment information like never before. Free for candidates.</p>
        </div>

        <div class="lg:relative lg:h-14">
            <div class="absolute top-1/2 w-full h-[1px] bg-gray-300 lg:block hidden"></div>
            <div class="lg:absolute lg:left-1/2 lg:-translate-x-[95px] flex items-center lg:gap-20 gap-5 lg:flex-row flex-col">
                <x-buttons.primary elem_type="link" href="{{ route( 'auth' ) }}" size="xl">Create your profile now</x-buttons.primary>
                {{-- <x-buttons.secondary size="xl" class="cursor-not-allowed"> <x-icon name="zondicon-envelope" class="w-4 h-4 mr-2 text-gray-300" />  Email me a reminder</x-buttons.secondary> --}}
            </div>
        </div>
    </div>

    {{-- top 10 schools or whatever we might architecture it later --}}
    <div class="flex flex-col gap-10 text-gray-600 pb-20">
        <livewire:dashboard.school-board />
    </div>
</div>
