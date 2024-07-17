<x-dashboard-layout>
    <div>
        <div class="lg:px-0 px-20 max-w-8xl mx-auto">
            <x-app.common.page_header mobileMenuSelectedIndex='2'>
                <x-slot name="column_left">
                    <x-app.school.avatar class="max-w-56" :campus="\Illuminate\Support\Facades\Session::get( 'current_campus' )" />
                    <x-buttons.secondary elem_type="link" href="{{ route( 'school.campus_profile' ) }}" class="w-full max-w-56 mb-4 mt-6 flex justify-center py-3 !font-light !text-xl">Update Profile</x-buttons.secondary>
                </x-slot>

                <x-text.heading class="mt-12 text-center w-full" variant="h1">{{ $school->primary_profile?->name ?? $school->name }}</x-text.heading>
                {{--    <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 text-center w-full lg:block hidden"><pre>{{ print_r($debug, true) }}</pre></x-text.heading>   --}}
            </x-app.common.page_header>

            @if(\Illuminate\Support\Facades\Request::get('subscription_error'))
                <x-notifications.notice class="mb-4 !text-xl !font-light !px-6 !py-4 text-center mb-8">
                    Your current subscription does not allow you to access this feature. Would you like to upgrade your subscription?.<br />
                </x-notifications.notice>
            @endif

            <livewire:school.settings.plans />

{{--            <div class="w-full mb-20">--}}
{{--                <div class="w-full flex lg:flex-row mb-10 justify-center items-center">--}}
{{--                    <x-text.heading variant="h5" class="my-0 text-xl lg:text-3xl text-gray-500 text-center mr-5">Your plan</x-text.heading>--}}
{{--                </div>--}}
{{--                <div class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 grid-rows-12 justify-center items-start gap-x-6">--}}
{{--                    @foreach( $plans as $plan )--}}
{{--                        @php $previous_plan_features = ( $loop->index > 0 ) ? $plans[$loop->index - 1]->features : [] @endphp--}}
{{--                        <livewire:school.plan-card :plan="$plan" :previous_features="$previous_plan_features" :active="Session::get( 'current_school' )->subscription?->plan->id == $plan->id"/>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="w-full mb-20">
                <div class="w-full flex lg:flex-row mb-10 justify-center items-center">
                    <x-text.heading variant="h5" class="my-0 text-3xl text-gray-500 text-center mr-5">Update </x-text.heading>
                    <x-text.heading variant="h5" class="my-0 text-3xl text-school_primary text-center"> your settings</x-text.heading>
                </div>
                <div class="w-full flex flex-col justify-center align-center">
                    @foreach($settingList as $setting)
                        <livewire:school.setting-card :setting="$setting" />
                    @endforeach
                </div>
            </div>
        </div>

        <livewire:school.settings.modals.setting_modals wire:key="settings_modals"/>
    </div>
</x-dashboard-layout>
