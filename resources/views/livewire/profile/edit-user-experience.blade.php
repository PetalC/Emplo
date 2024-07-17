<div class="col-span-2">

    <div class="flex flex-col gap-10">
        <x-input.outline wire:model.live.debounce.400="company" label="Company" placeholder="Company name" />
        <x-input.outline wire:model.live.debounce.400="role" label="Position" placeholder="Position" />

        <div class="grid grid-cols-2 gap-x-5">
            <x-input.datepicker wire:model.live="started_at" label="From" />
            <x-input.datepicker wire:model.live="ended_at" label="To" />
        </div>

        <x-input.textarea wire:model.live.debounce.400="story" label="Description" rows="5" />
    </div>

{{--    @TODO Add a confirmation--}}
    <x-buttons.danger class="mt-6 float-right" :shadow="false" wire:click="deleteExperience()">Delete Experience</x-buttons.danger>

</div>
