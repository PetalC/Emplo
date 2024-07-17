<div>
    <div x-data="{ open: @entangle('open_modal').live }">
        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">
            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Employer Logo
            </h4>

            <div>
                <p class="text-3xl text-gray-500">Upload your school logo</p>
                <div class="w-full mt-16 flex gap-10 items-center">
                    <x-input.upload class="w-44 aspect-square flex items-center justify-center" :media="$profile->getFirstMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value )" id="logo_upload_file" accept="image/*" wire:model.live="logo_upload_file" />
                    <p class="text-gray-500 flex-grow">
                        This should be a square image, and no more than 1MB.
                    </p>
                </div>
                @error('logo_upload_file') <p class="text-red-500">{{ $message }}</p> @enderror
            </div>

            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false;">Save</x-buttons.primary>
        </x-modal>
    </div>
</div>
