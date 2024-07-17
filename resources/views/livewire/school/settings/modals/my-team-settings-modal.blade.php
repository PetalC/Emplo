<div>
    <div x-data="{ open: @entangle('open_modal').live, showForm: false }">
        <x-modal size="lg" x-show="open" class="overflow-y-scroll" onClose="open = false;">
            <h4 class="text-2xl font-light whitespace-nowrap text-center mb-10">
                My Team
            </h4>

            <div class="mb-8">
                <h5 class="text-xl font-medium mb-4">Existing Users</h5>
                <div class="space-y-4">
                    @foreach($users as $user)
                        <div class="p-4 border rounded-lg shadow">
                            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Role:</strong> {{ implode(', ', $this->getAllowedRoles($user)) }}</p>
                            <x-buttons.secondary @click="showForm = true; $wire.editUser({{ $user->id }})">Edit</x-buttons.secondary>
                            @if ($user->id !== Auth::user()->id)
                            <x-buttons.secondary  class="text-red-500" wire:click="removeFromSchool({{ $user->id }})" wire:confirm.prompt="Are you sure?\n\nType REMOVE to confirm|REMOVE">Remove</x-buttons.secondary>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mb-4">
                <x-buttons.primary wire:click="resetForm; showForm = true">Add User</x-buttons.primary>
            </div>


            <div x-show="showForm" class="mt-6">
            <form wire:submit.prevent="submitForm">
                <div class="mb-4">
                    <x-input.outline variant="row" wire:model.live.debounce.200ms="first_name" label="First Name" id="first_name" name="first_name" placeholder="Enter first name" />
                </div>
                <div class="mb-4">
                    <x-input.outline variant="row" wire:model.live.debounce.200ms="last_name" label="Last Name" id="last_name" name="last_name" placeholder="Enter last name" />
                </div>
                <div class="mb-4">
                    <x-input.outline variant="row" wire:model.live.debounce.200ms="email" label="Email" id="email" name="email" placeholder="Enter email" />
                </div>
                <div class="mb-4">
                    <x-input.outline variant="row" wire:model.live.debounce.200ms="password" label="Password" id="password" name="password" type="password" placeholder="Enter password" />
                </div>
                <div class="mb-4">
                    <x-input.select id="newUserRole" wire:model.live="newUserRole" name="newUserRoles" label="Role" :options="$roles" placeholder="Choose Role"></x-input.select>
                </div>
                <x-buttons.primary class="mt-10 mx-auto" type="submit">Save</x-buttons.primary>
            </form>
            </div>
            <script>
                document.addEventListener('livewire:load', function () {
                    Livewire.on('confirmRemove', userId => {
                        if (confirm('Are you sure you want to remove this user from the school?')) {
                            Livewire.emit('removeFromSchool', userId);
                        }
                    });
                });
            </script>
        </x-modal>
    </div>
</div>
