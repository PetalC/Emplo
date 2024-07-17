@php use App\Enums\SystemEmailTypes; @endphp
@props([
    'onClose' => null
])

@php
    switch ($email_type) {
        case SystemEmailTypes::REQUEST_REFERENCES->value:
            $formTitle = 'Request References for';
            break;
        default:
            $formTitle = 'Email Applicant';
    }
@endphp

<div class="gap-10 w-full">
    <h1>{{ $formTitle }} {{ $application->user->name }}</h1>
    <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10 pt-20">
        <div class="flex flex-col md:grid md:grid-cols-3 md:flex-row gap-x-5 gap-y-16">

            <div class="md:col-span-3">
                <x-input.select id="template" name="template" label="Email Template" placeholder="Choose a template" :options="$email_template_options" wire:model.blur="email_details.template"/>
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="subject" name="subject" label="Email subject" placeholder="Subject"
                                 wire:model.blur="email_details.subject"/>
            </div>

            <div class="md:col-span-3">
                <x-input.textarea id="message" name="message" label="Message" placeholder="Email message content"
                                  wire:model.blur="email_details.message"/>
                <span>Please make sure you replace the values in the message with your data</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- Preview not supported --}}
            {{--                    <x-buttons.secondary>Preview</x-buttons.secondary>--}}
            <x-buttons.primary wire:click="sendEmail" x-on:click="showEmailApplicantModal = false">
                {{--                <x-icons.check-mark />--}}
                Send
            </x-buttons.primary>
        </div>
    </div>
</div>
