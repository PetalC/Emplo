<div>
    <div x-data="{ open: @entangle( 'open_modal' ).live }">

        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">

            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Job Boards
            </h4>

            @foreach($board_settings as $board => $credentials)
                <h3>{{ ucfirst($board) }}</h3>
                <x-input.outline
                    variant="row"
                    wire:model.live.debounce.200ms="board_settings.{{ $board }}.account_number"
                    label="{{ ucfirst($board) }} Account Number"
                    id="{{ $board }}_account_number"
                    name="{{ $board }}_account_number"
                    placeholder="Account Number"
                />
                <x-input.outline
                    variant="row"
                    wire:model.live.debounce.200ms="board_settings.{{ $board }}.api_key"
                    label="{{ ucfirst($board) }} API Key"
                    id="{{ $board }}_api_key"
                    name="{{ $board }}_api_key"
                    placeholder="API Key"
                />
            @endforeach


            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false">Save</x-buttons.primary>
        </x-modal>
    </div>
</div>
