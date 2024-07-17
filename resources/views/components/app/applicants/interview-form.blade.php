<div class="gap-10 w-full pt-20">
    <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10">
        <div class="form-header">
            <div class="flex flex-row">
{{--                <x-icon.envelope />--}}
                <h1>Interview confirmation</h1>
            </div>
            <x-buttons.secondary>Save and close</x-buttons.secondary>
        </div>
        <div class="flex flex-col md:grid md:grid-cols-3 md:flex-row gap-x-5 gap-y-16">

            <div>
                <x-input.select id="time" name="time" label="Time" placeholder="Choose option" :options="['1pm' => '13:00', '2pm' => '14:00']" wire:model.blur="interview.time" />
            </div>

            <div>
                <x-input.select id="day" name="day" label="Day" placeholder="Choose option" :options="['mon' => 'Monday', 'tue' => 'Tuesday']" wire:model.blur="interview.day" />
            </div>

            <div>
                <x-input.select id="month" name="month" label="Month" placeholder="Choose option" :options="['1' => 'Jan', '2' => 'Feb']" wire:model.blur="interview.month" />
            </div>

            <div>
                <x-input.select id="type" name="type" label="Interview Type" placeholder="Choose option" :options="['Type 1' => 't1', 'Type 2' => 't2']" wire:model.blur="interview.type" />
            </div>

            <div>
                <x-input.select id="address" name="address" label="Address" placeholder="Choose option" :options="['1' => 'Address 1', '2' =>'Address 2']" wire:model.blur="interview.address" />
            </div>

            <div>
                <x-input.outline id="link" name="link" label="Link" placeholder="Any relevant link" wire:model.blur="interview.link" />
            </div>

            <x-app.applicants.panel-selector :job />

            <div class="md:col-span-3">
                <x-input.select id="template" name="template" label="Email Template" placeholder="Choose a template" :options="['1' => 'Interview 1 Template', '2' =>'Interview 2 Template']" wire:model.blur="interview_email.template" />
            </div>

            <div class="md:col-span-3">
                <x-input.outline id="subject" name="subject" label="Email subject" placeholder="Subject" wire:model.blur="interview_email.subject" />
            </div>

            <div class="md:col-span-3">
                <x-input.textarea id="message" name="message" label="Nessage" placeholder="Email message content" wire:model.blur="interview_email.message" />
            </div>

        </div>
        <div class="form-footer">
            <div class="flex flex-row">
                <x-buttons.secondary>
                    <x-icon type="paperclip" />
                    Add attachments
                </x-buttons.secondary>
                <div>
                    <x-button.primary>Send</x-button.primary>
                    <x-button.secondary>Add to Calendar</x-button.secondary>
                </div>
            </div>
            <x-buttons.secondary>Save and close</x-buttons.secondary>
        </div>

    </div>
</div>
