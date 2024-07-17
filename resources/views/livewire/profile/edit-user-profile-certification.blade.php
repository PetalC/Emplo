<div class="col-span-2">

    <div class="flex flex-col gap-10">
        <x-input.outline wire:model.live.debounce.400="institution" label="Institution" placeholder="Institution" />
        <x-input.outline wire:model.live.debounce.400="certification" label="Position" placeholder="Certification" />

        <div class="grid grid-cols-1 gap-x-5">
            <x-input.datepicker wire:model.live="completed_at" label="Date Completed" />
{{--            <x-input.datepicker wire:model.live="ended_at" label="To" />--}}
        </div>

        <x-input.textarea wire:model.live.debounce.400="description" label="Description" rows="5" />
    </div>

{{--    @TODO Add a confirmation--}}
    <x-buttons.danger class="mt-6 float-right" :shadow="false" wire:click="deleteCertification()">Delete Certification</x-buttons.danger>

</div>
