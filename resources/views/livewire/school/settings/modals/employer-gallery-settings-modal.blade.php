<div>
    <div x-data="{ open: @entangle('open_modal').live }">
        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">
            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Employer Gallery
            </h4>

            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false;">Save</x-buttons.primary>
        </x-modal>
    </div>
</div>
