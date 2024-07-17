<div>
    <div x-data="{ open: @entangle( 'open_modal' ).live }">

        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">

            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Social Media
            </h4>

            <x-input.outline variant="row" wire:model.live.debounce.200ms="facebook" label="Facebook" id="facebook_url" name="facebook_url" placeholder="URL" />
            <x-input.outline variant="row" wire:model.live.debounce.200ms="instagram" label="Instagram" id="instagram_url" name="instagram_url" placeholder="URL" />
            <x-input.outline variant="row" wire:model.live.debounce.200ms="linkedin" label="Linkedin" id="linkedin_url" name="linkedin_url" placeholder="URL" />
            <!-- <x-buttons.primary class="mt-5 ml-20" elem_type="link" href="{{ url('auth/linkedin') }}">Connect to Linkedin</x-buttons.primary> -->

            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false">Save</x-buttons.primary>
            
        </x-modal>
    </div>
</div>
