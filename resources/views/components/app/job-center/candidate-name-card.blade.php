@props([
    'label'
])

<div class="bg-sky-100 p-2 rounded-lg flex text-sky-600	 text-xl items-center gap-2">
    <p>
        {{ $label }}
    </p>
    <p>
        ...
    </p>
    <x-icon name="heroicon-c-x-mark" class="w-5 h-5 hover:bg-sky-50 rounded-lg" wire:click="dispatch('candidate-removed')" />
</div>
