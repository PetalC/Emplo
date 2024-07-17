<div class="flex flex-col md:grid md:grid-cols-2 md:gap-5 justify-start text-left md:relative">
    <div class="md:col-start-1">
        <x-input.outline label="Full name" placeholder="Your referee's full name" wire:model.live.debounce.500="name" />
    </div>

    <div class="md:col-start-2">
        <x-input.outline label="Position and school/organisation" placeholder="Your referee's position and organisation" wire:model.live.debounce.500="position" />
    </div>

    <div class="md:col-start-1">
        <x-input.outline label="Phone number" placeholder="Your referee's phone number" wire:model.live.debounce.500="phone_number" />
    </div>

    <div class="md:col-start-2">
        <x-input.outline label="Email address" placeholder="Your referee's email address" wire:model.live.debounce.500="email" />
    </div>

    <div class="md:col-start-2 justify-self-end">
        <x-buttons.secondary wire:click="$parent.removeReference( {{ $reference->id }} )">Remove Referee</x-buttons.secondary>
    </div>

</div>
