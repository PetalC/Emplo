@props([
    'application',
    'show'
])
<div x-data="{ open: false }">
    <x-modal x-show="open"
             x-on:click.outside="open = false"
             onClose="open = false">
        <h2>Application Interview schedule form</h2>
    </x-modal>
</div>
