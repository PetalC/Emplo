<div class="col-span-2">

    <div class="flex flex-col gap-10">
        <x-input.outline wire:model.live.debounce.400="school" label="School / University" placeholder="School / University" />
        <x-input.outline wire:model.live.debounce.400="degree" label="Certification" placeholder="Certification" />

        <div class="grid grid-cols-2 gap-x-5">
            <x-input.datepicker wire:model.live="started_at" label="From" />
            <x-input.datepicker wire:model.live="ended_at" label="To" />
        </div>

        <x-input.textarea wire:model.live.debounce.400="story" label="Description" rows="5" />
    </div>

{{--    @TODO Add a confirmation--}}
    <x-buttons.danger class="mt-6 float-right" :shadow="false" wire:click="deleteEducation()">Delete Education</x-buttons.danger>

</div>
