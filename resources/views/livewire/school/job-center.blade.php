<div class="lg:px-0 px-20 pb-14 max-w-8xl mx-auto ">

    <x-app.common.page_header mobileMenuSelectedIndex="{{3}}">
        <x-slot name="column_left">
            {{-- MERGE CONFLICT             <x-app.school.avatar class="max-w-36" :campus="$campus" /> --}}
            <x-app.school.avatar class="max-w-56" :campus="\Illuminate\Support\Facades\Session::get( 'current_campus' )" />
            <x-buttons.secondary elem_type="link" href="{{ route( 'school.campus_profile' ) }}" class="w-full max-w-56 mb-4 mt-6 flex justify-center py-3 !font-light !text-xl">Update Profile</x-buttons.secondary>
        </x-slot>
        <x-slot name="column_right">
            <div class="flex flex-col gap-5 mt-10">
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.jobcenter.index') }}" class="py-4 justify-center {{ $status === \App\Enums\JobStatus::OPEN ? '!bg-primary !text-white !border-none' : '' }}">Open Jobs</x-buttons.secondary>
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.jobcenter.closed') }}"  class="py-4 justify-center {{ $status === \App\Enums\JobStatus::CLOSED ? '!bg-primary !text-white !border-none' : '' }}">Closed Jobs</x-buttons.secondary>
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.jobcenter.draft') }}" class="py-4 justify-center {{$status === \App\Enums\JobStatus::DRAFT ? '!bg-primary !text-white !border-none' : '' }}">Draft Jobs</x-buttons.secondary>
                <x-buttons.secondary class="py-4 px-4 justify-center cursor-not-allowed opacity-80">Generate Report</x-buttons.secondary>
            </div>
        </x-slot>

        <x-text.heading variant="h1" class="mb-4  text-gray-500 text-center w-full">{{ \Illuminate\Support\Facades\Session::get( 'current_campus' )->primary_profile->name }}</x-text.heading>
        <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 text-center w-full">
            {{ $jobs->total() }} {{ $status }} {{ \Illuminate\Support\Str::plural('Role', $jobs->total() )}}
        </x-text.heading>

    {{--    <x-button.outline class="lg:w-fit w-full lg:hidden block cursor-not-allowed opacity-80">Generate Report</x-button.outline>--}}

    </x-app.common.page_header>

    {{-- right button--}}


    <hr class="lg:hidden block my-20"/>

    <div class="flex flex-col justify-between gap-20">

            <div class="w-full lg:mt-0">
                @if(!$interviews->isEmpty())
                    {{--Upcoming interviews--}}
                    <p class="text-4xl text-gray-500 lg:text-left text-center">Upcoming interviews</p>
                    @foreach($interviews as $interview)
{{--                        <x-app.job-center.interview-card />--}}
                        <livewire:job-center.interview-card wire:key="interview_{{ $interview->id }}" :interview="$interview" :panel-member-names="$interview_panel_names" />
                    @endforeach
                @endif
            </div>

        <hr class="lg:hidden block my-10"/>

        {{--Open roles--}}
        <div class="w-full" id="roles_list">
            <div class="flex lg:flex-row flex-col lg:justify-between justify-center">
                <p class="text-4xl text-gray-500 text-center lg:text-left mb-10 lg:mb-0"> {{ $status }} roles </p>
                <div class="lg:flex hidden gap-5">
                    <div class="p-3 flex gap-3 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-50" wire:click="select_all">
                        <x-icons.check-box />
                        Select all
                    </div>
                    <div class="p-3 flex gap-3 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-50" wire:click="unselect_all">
                        <x-icons.uncheck-box />
                        Unselect all
                    </div>
                    <div class="p-3 flex gap-3 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-50" wire:navigate @click="window.location = '{{ route( 'school.jobcenter.create' ) }}'">
                        <x-icons.plus />
                        Create New Ad
                    </div>
                    <div class="p-3 flex gap-3 bg-gray-100 rounded-lg cursor-pointer hover:bg-gray-50"
                         wire:click.stop="duplicateSelectedAds"
                    >
                        <x-icon name="heroicon-o-clipboard-document" class="w-6 h-6" />
                        Clone Job(s)
                    </div>
                    <div class="p-3 flex gap-3 bg-gray-100 rounded-lg items-center cursor-pointer hover:bg-gray-50"
                         wire:click="removeSelectedAds"
                         wire:confirm.prompt="Are you sure you want to remove these ad(s)?\n\nType REMOVE to confirm|REMOVE"
                    >
                        <x-icons.x-mark class="!w-5 !h-5"/>
                        Remove Ad(s)
                    </div>
                </div>
                <livewire:school.job-operation-menu />
            </div>
            <div class="grid grid-cols-12 lg:gap-10 gap-y-10 mt-20">
                @forelse( $jobs as $job )
                    <livewire:job-center.job-card wire:key="job_{{ $job->id }}" wire:model="selected_jobs.{{ $job->id }}" :job="$job" />
                @empty
                    <x-notifications.notice class="col-span-12">No Jobs Found</x-notifications.notice>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $jobs->links( data: [ 'scrollTo' => '#roles_list' ] ) }}
            </div>

        </div>

        <hr class="lg:hidden block my-10"/>

        {{--Closed roles--}}
{{--        <div class="w-full">--}}
{{--            <div class="flex lg:justify-between justify-center">--}}
{{--                <p class="text-4xl text-gray-500"> Closed roles </p>--}}
{{--            </div>--}}
{{--            <div class="flex flex-col gap-10 mt-20">--}}
{{--                <livewire:school.role-card closed='{{ true }}'/>--}}
{{--            </div>--}}
{{--        </div>--}}

        {{--Administrative chat--}}
        <div class="text-app justify-center flex flex-col gap-20 opacity-40 cursor-not-allowed">
            <div class="flex justify-center">
                <x-icons.speech />
                <span class="ml-2">Administrative chat</span>
            </div>
            <div class="lg:border rounded-lg border-gray-500 lg:px-10 lg:py-5">
                <div class="lg:h-64 py-5 flex flex-col gap-5">
                    <x-app.job-center.incoming-message label="Jane, Jim and Trent all look fantastic." name="TI" time="Today, 1:31pm"/>
                    <x-app.job-center.incoming-message label="Jim and Trent look good but they don't have optimal accredidation and have not provided all references yet-we ideally need to interview asap for this role" name="TI" time="Today, 1:34pm"/>
                    <x-app.job-center.outgoing-message label="I agree, Jane looks great" name="LE" time="Today, 2pm"/>
                </div>
                <hr class="-mx-10 lg:block hidden"/>
                <div class="lg:h-20 pt-5 flex lg:flex-row flex-col lg:justify-between lg:items-start items-end">
                    <div class="flex gap-5 items-center w-full lg:w-fit">
                        <x-input.text id="admin_search" name="admin_search"></x-input.text>
                        <x-button.outline class="lg:block hidden">Search</x-button.outline>
                    </div>
                    <x-button.outline class="lg:mt-0 mt-5">Post</x-button.outline>
                </div>
            </div>
        </div>
    </div>
</div>
