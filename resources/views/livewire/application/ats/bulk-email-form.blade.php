@props([
    'onClose' => null
])
<div class="gap-10 w-full">

    @if( $email_sent )
        <x-notifications.success>Email sent successfully</x-notifications.success>
    @endif

    @if(empty($selected_emails))
            <h1 class="text-xl font-light mt-10">No Applicants Selected. Please select an applicant to email.</h1>
    @else

            <h1>Email {{ count( $selected_emails ) }} Applicants</h1>

            <div class="flex gap-2 flex-col mt-5">
                @foreach($selected_emails as $email)
                    <span class="border bg-gray-100 px-2 py-1 rounded">{{ $email }}</span>
                @endforeach
            </div>

            <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10 pt-6">
                <div class="flex flex-col md:grid md:grid-cols-3 md:flex-row gap-x-5 gap-y-8">

{{--            <div class="md:col-span-3">--}}
{{--                <x-input.select id="template" name="template" label="Email Template" placeholder="Choose a template" :options="$email_template_options" wire:model.blur="email_details.template" />--}}
{{--            </div>--}}

                    <div class="md:col-span-3">
                        <x-input.outline id="subject" name="subject" label="Email subject" placeholder="Subject" wire:model.blur="email_details.subject" />
                    </div>

                    <div class="md:col-span-3">
                        <x-input.textarea id="message" name="message" label="Message" placeholder="Email message content" wire:model.blur="email_details.message" />
                        <div class="text-sm text-gray-800 mt-2">Please make sure you generalise the values in your message to apply to all applicants</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Preview not supported --}}
{{--                    <x-buttons.secondary>Preview</x-buttons.secondary>--}}
                    <x-buttons.primary class="flex justify-between" wire:click="sendEmail">
                        {{--                <x-icons.check-mark />--}}
                        Send
                    </x-buttons.primary>
                </div>

            </div>

    @endif

</div>
