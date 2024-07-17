<div>
    <div x-data="{ open: @entangle('open_modal').live }">
        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">
            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Change Password
            </h4>

            <div class="mb-6">
                <x-input.outline type="password" wire:model.defer="currentPassword" label="Current Password" />
                @error('currentPassword') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <x-input.outline type="password" wire:model.defer="newPassword" label="New Password" />
                @error('newPassword') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <x-input.outline type="password" wire:model.defer="confirmPassword" label="Confirm Password" />
                @error('confirmPassword') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false;">Save</x-buttons.primary>
        </x-modal>
    </div>
</div>
