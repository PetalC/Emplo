<div>
    <div x-data="{ open: @entangle('open_modal').live }">
        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">
            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                Employer Locations
            </h4>
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="addCampus" class="mb-4">
                <x-input.outline variant="row" wire:model.live.debounce.200ms="newCampusName" label="Campus Name" id="newCampusName" name="newCampusName" placeholder="Enter campus name" />

                <x-input.outline variant="row" wire:model.live.debounce.200ms="newCampusAddress" label="Campus Address" id="newCampusAddress" name="newCampusAddress" placeholder="Enter campus address" />

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Campus</button>
            </form>



            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Campuses</h2>
                <div class="space-y-4">
                    @foreach ($campuses as $campus)
                        @if($campus->primary_profile)
                        <div class="bg-white shadow rounded p-4">
                            <h3 class="text-lg font-semibold">{{ $campus->primary_profile->name }}</h3>
                                <div class="mt-2">
                                    <h4 class="text-md font-semibold">Details</h4>
                                    <p class="text-gray-600">Detail 1: {{ $campus->primary_profile->name }}</p>
                                    <p class="text-gray-600">Detail 2: {{ $campus->primary_profile->address }}</p>
                                    <!-- Add more profile details as needed -->
                                </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>



            <x-buttons.primary class="mt-10 mx-auto" wire:click="submitForm(); open = false;">Save</x-buttons.primary>
        </x-modal>
    </div>
</div>
