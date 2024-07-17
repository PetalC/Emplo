<div class="text-app flex items-center flex-col gap-10">
    <p class="text-3xl text-center">All our packages are designed to be low cost & high value.<br/>From the features you've chosen I'll organise a price in minutes. Ready? </p>

    <div class="flex flex-col gap-10 w-2/3">
        <x-input.outline id="service-wizard-first-name" name="service-wizard-first-name" label="First Name" />
        <x-input.outline id="service-wizard-sur-name" name="service-wizard-sur-name" label="Sur Name" />
        <x-input.outline id="service-wizard-school-name" name="service-wizard-school-name" label="School Name" />
        <x-input.outline id="service-wizard-email" name="service-wizard-email" label="Email Address" />
    </div>
    <x-button.primary wire:click="updateParentValue(5)">employGo</x-button.primary>
</div>
