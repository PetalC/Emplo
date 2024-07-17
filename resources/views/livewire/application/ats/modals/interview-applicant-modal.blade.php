@php use Carbon\Carbon; @endphp
<div x-data="{ open: @entangle( 'open_modal' ).live }">

    <x-modal :withClose="false" size="lg" x-show="open" class="overflow-y-scroll">

        @if( $applications->isEmpty() )

            <div class="w-full lg:min-w-[800px] flex justify-between">

                <div class="flex gap-4 items-center ">

                    <x-icon name="heroicon-o-envelope" class="w-8 h-8"/>

                    <h4 class="text-2xl font-light whitespace-nowrap flex gap-2 items-center">
                        Interview Confirmation
                    </h4>

                </div>

                <x-buttons.secondary @click="open = false">Cancel</x-buttons.secondary>

            </div>

            <h1 class="text-xl font-light mt-10">No Applicants Selected. Please select an applicant to proceed with an interview.</h1>

        @elseif( $is_complete )

            <div class="w-full lg:min-w-[800px] flex justify-between">

                <div class="flex gap-4 items-center ">

                    <x-icon name="heroicon-o-envelope" class="w-8 h-8"/>

                    <h4 class="text-2xl font-light whitespace-nowrap flex gap-2 items-center">
                        Interview Confirmation
                    </h4>

                </div>

                <x-buttons.secondary @click="open = false">Cancel</x-buttons.secondary>

            </div>

            <h1 class="text-xl font-light mt-10">Interview scheduled successfully.</h1>

        @else

            <div class="w-full lg:min-w-[800px] flex justify-between">

                <div class="flex gap-4 items-center ">

                    <x-icon name="heroicon-o-envelope" class="w-8 h-8"/>

                    @php

                        $template = '<span class="bg-school_primary text-white px-2 py-1 text-xs rounded">%s</span>';

                        $html = '';

                        foreach( $applications as $application ){
                            $html .= sprintf( $template, $application->user->name );
                        }
                    @endphp
                    <h4 class="text-2xl font-light whitespace-nowrap flex gap-2 items-center">
                        Interview Confirmation
                        {!! $html !!}
                    </h4>

                </div>

                <x-buttons.secondary @click="open = false">Cancel</x-buttons.secondary>

            </div>

            <div class="grid grid-cols-3 gap-8 py-12 items-end">

                <div>
                    <x-input.select wire:model.live="form_fields.time" :associative="false" :options="$available_times" label="Time"></x-input.select>
                </div>

                <div>
                    <x-input.select wire:model.live="form_fields.day" :associative="false" :options="range( 1, 31 )" label="Day"></x-input.select>
                </div>

                <div>
                    <x-input.select wire:model.live="form_fields.month" :options="$available_months" label="Month"></x-input.select>
                </div>

                <div>
                    <x-input.select wire:model.live="form_fields.interview_type" :options="$interview_types" label="Interview Type"></x-input.select>
                </div>

                <div class="opacity-20 cursor-not-allowed">
                    {{--                wire:model="form_fields.address"--}}
                    <x-input.select :options="[ 1 => 'Office Address', 2 => 'Secondary Address' ]" label="Address"></x-input.select>
                </div>

                <div>
                    <x-input.outline wire:model.live.debounce.200ms="form_fields.link" label="Link"></x-input.outline>
                </div>

                <div class="col-span-3">
                    <livewire:forms.multi-select :key="'form_fields.panel_members'" wire:model.live="form_fields.panel_members" :with_search="false" :options="$available_members?->pluck( 'name', 'id' )->toArray() ?? []"  label="Panel Members" />
                </div>

                <div class="col-span-3">
                    <x-input.outline wire:model.live="email_subject" label="Email Subject"></x-input.outline>
                </div>

                <div class="col-span-3">
                    <livewire:forms.richtextarea wire:model.live="email_body" :error="$errors->first( 'email_body' )" label="Message" id="interview_email_body" />
                </div>

                <div class="col-span-3">
                    @foreach( $attachments as $attachment )
                        <div class="flex gap-4 items-center mt-2" >
                            <x-icon name="heroicon-o-trash" class="w-6 h-6 text-danger cursor-pointer" wire:click="removeAttachment( {{ $attachment->id }} )" />
                            <a href="{{ env( 'APP_ENV' ) === 'local' ? $attachment->getUrl() : $attachment->getTemporaryUrl( now()->addMinutes( 5 ) ) }}" target="_blank" class="text-blue-500">{{ $attachment->file_name }}</a>
                        </div>
                    @endforeach
                </div>

                {{--            <div>--}}
                {{--                <x-buttons.secondary class="self-center justify-self-center">Add Panel Members</x-buttons.secondary>--}}
                {{--            </div>--}}

            </div>

            <div class="flex items-center justify-between mt-8">

                <div class="flex items-center gap-3">
                    <x-input.upload accept="application/*,image/*" class="border-none p-0 !flex justify-normal gap-0" wire:model="attachment_upload" id="interview-attachments">
                        <div>
                            <x-buttons.secondary :shadow="false">
                                <x-icon name="heroicon-o-paper-clip" class="w-5 h-5 mr-2"/>
                                Attach A File
                            </x-buttons.secondary>
                        </div>
                    </x-input.upload>
                    <x-buttons.secondary class="whitespace-nowrap opacity-20 cursor-not-allowed" :shadow="false">
                        <x-icon name="heroicon-o-calendar" class="w-5 h-5 mr-2"/>
                        Add To Calendar
                    </x-buttons.secondary>
                </div>

                <div>
                    <x-buttons.primary wire:click="submitForm" :shadow="false">
                        Send
                    </x-buttons.primary>
                </div>

            </div>

            @error( 'attachment_upload' )
                <div class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </div>
            @enderror

        @endif


    </x-modal>

</div>
