<div class="flex-col">
    <x-input.checkbox id="reference_checks" name="reference_checks" label="All required reference checks" wire:model.blur="checkboxes.reference_checks" />
    <x-input.checkbox id="licensing" name="licensing" label="Licensing/Registration" wire:model.blur="checkboxes.licensing" />
    <x-input.checkbox id="working_children" name="working_children" label="Working with Children Check" wire:model.blur="checkboxes.working_children" />
    <x-input.checkbox id="application_form" name="application_form" label="Application Form (if applicable)" wire:model.blur="checkboxes.application_form" />
</div>
