    <x-dashboard-layout>

        <h2 class="text-xl mt-10 text-center">
            Please check the <a class="text-school_primary" href="{{ route( 'school.jobcenter.index' ) }}">Job Center</a> and look for the <x-buttons.primary class="mx-2 -translate-y-[2px] opacity-50 cursor-not-allowed" :disabled :shadow="false" disabled>Manage Candidates</x-buttons.primary> button to manage applicants.
        </h2>

{{--        <h3>Dummy job selector page</h3>--}}
{{--        @foreach($school->jobs as $job)--}}
{{--            <livewire:school.job-card :job="$job" />--}}
{{--        @endforeach--}}

{{--        <x-app.job.page-header :job="$job" :applications="$applications" :selected_applicants="$selected_applicants">--}}
{{--            <x-slot name="column_left">--}}

{{--            </x-slot>--}}
{{--            <x-slot name="column_right">--}}
{{--                <div class="flex flex-col items-center">--}}
{{--                    <x-buttons.secondary class="mt-16">Generate Report</x-buttons.secondary>--}}
{{--                    <!-- Filter candidates -->--}}
{{--                    <x-select.dropdown label="Filter Candidates" class="mt-2 md:mt-16">--}}

{{--                    </x-select.dropdown>--}}
{{--                </div>--}}
{{--            </x-slot>--}}
{{--        </x-app.job.page-header>--}}

{{--    <div class="block justify-between px-20 xl:flex">--}}
{{--        <div>--}}
{{--            <div class="flex flex-col items-center">--}}
{{--                <div class="w-56 h-56 rounded-lg overflow-hidden bg-white border border-black flex items-center justify-center transform mt-6 xl:-mt-14">--}}
{{--                    <img src="{{ asset('assets/app/school-1-logo.png') }}" class="w-32 h-32"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--            <x-text.heading class="mt-12 text-center" variant="h1">Director of People and Culture</x-text.heading>--}}

{{--            <div class="flex flex-col xl:flex-row justify-center gap-8 items-center mt-8">--}}

{{--                <div class="text-3xl">--}}
{{--                    $143,000--}}
{{--                </div>--}}

{{--                <div class="flex gap-2">--}}
{{--                    <span class="inline-block text-black bg-gray-100 rounded px-2 py-1">Tag</span>--}}
{{--                    <span class="inline-block text-black bg-gray-100 rounded px-2 py-1">Something</span>--}}
{{--                    <span class="inline-block text-black bg-gray-100 rounded px-2 py-1">Something Else</span>--}}
{{--                </div>--}}

{{--                <div class="text-gray-600 flex gap-2 items-center">--}}
{{--                    <x-icon name="heroicon-o-clock" class="w-6 h-6" />--}}
{{--                    <span>--}}
{{--                        One Day Ago--}}
{{--                    </span>--}}
{{--                </div>--}}

{{--            </div>--}}

{{--            <p class="text-center mt-8 text-gray-600">--}}
{{--                Commencing March 2024<br />--}}
{{--            </p>--}}
{{--            @if(!$applications->isEmpty())--}}
{{--            <p class="text-center mt-8 text-gray-600">{{ count($applications) }} Applied</p>--}}
{{--            @endif--}}

{{--        </div>--}}

{{--        <div class="flex flex-col items-center">--}}
{{--            <x-buttons.secondary class="mt-16">Generate Report</x-buttons.secondary>--}}
{{--            <!-- Filter candidates -->--}}
{{--            <x-select.dropdown label="Filter Candidates" class="mt-2 md:mt-16">--}}

{{--            </x-select.dropdown>--}}
{{--        </div>--}}

{{--    </div>--}}

{{--    <div class="max-w-8xl mx-auto">--}}

{{--        <livewire:application.ats.application-table wire:model="selected_applicants" :applications="$applications" />--}}

{{--        <div class="mt-12 px-20">--}}

{{--            <p class="text-center">--}}
{{--                Job Role Chat--}}
{{--            </p>--}}

{{--            <div class="mt-10 py-10 border-t border-t-gray-200 flex flex-col gap-6 max-w-4xl mx-auto">--}}

{{--                <div class="flex items-start gap-2.5">--}}
{{--                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Jese image">--}}
{{--                    <div class="flex flex-col w-full max-w-[450px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">--}}
{{--                        <div class="flex items-center space-x-2 rtl:space-x-reverse">--}}
{{--                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie Green</span>--}}
{{--                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>--}}
{{--                        </div>--}}
{{--                        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome. I think our users will really appreciate the improvements.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex items-start gap-2.5 self-end">--}}
{{--                    <div class="flex flex-col w-full max-w-[450px] leading-1.5 p-4 border-gray-200 bg-blue-100 rounded-s-xl rounded-ee-xl dark:bg-gray-700">--}}
{{--                        <div class="flex items-center space-x-2 rtl:space-x-reverse">--}}
{{--                            <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie Green</span>--}}
{{--                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>--}}
{{--                        </div>--}}
{{--                        <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome. I think our users will really appreciate the improvements.</p>--}}
{{--                    </div>--}}
{{--                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Jese image">--}}
{{--                </div>--}}

{{--            </div>--}}


{{--            <div class="max-w-4xl mx-auto mb-10">--}}

{{--                <div class="flex gap-2">--}}
{{--                    <div class="flex-grow">--}}
{{--                        <x-input.outline class="rounded border px-2 !border-gray-200" name="post" id="post"></x-input.outline>--}}
{{--                    </div>--}}
{{--                    <x-buttons.secondary>Post</x-buttons.secondary>--}}
{{--                </div>--}}

{{--            </div>--}}


{{--        </div>--}}

{{--    </div>--}}

</x-dashboard-layout>
