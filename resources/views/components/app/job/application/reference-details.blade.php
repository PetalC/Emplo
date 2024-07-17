@props([
    'id',
    'index',
    'reference',
//    'min_references'
])
@php
$elementId = $id.$index;
@endphp

<div class="flex flex-col md:grid md:grid-cols-2 md:gap-5 justify-start text-left md:relative">
    <div class="md:col-start-1">
        <x-input.outline id="full_name_{{ $elementId }}" name="full_name_{{ $elementId }}" label="Full name" placeholder="Your referee's full name" wire:model.blur="references.{{$index}}.full_name" />
    </div>

    <div class="md:col-start-2">
        <x-input.outline id="school_position_{{ $elementId }}" name="school_position_{{ $elementId }}" label="Position and school/organisation" placeholder="Your referee's position and organisation" wire:model.blur="references.{{$index}}.position" />
    </div>

    <div class="md:col-start-1">
        <x-input.outline id="phone_number_{{ $elementId }}" name="phone_number_{{ $elementId }}" label="Phone number" placeholder="Your referee's phone number" wire:model.blur="references.{{$index}}.phone_number" />
    </div>

    <div class="md:col-start-2">
        <x-input.outline id="email_{{ $elementId }}" name="email_{{ $elementId }}" label="Email address" placeholder="Your referee's email address" wire:model.blur="references.{{$index}}.email" />
    </div>

    <div class="md:col-start-2 justify-self-end">
        <x-buttons.secondary wire:click="removeReference({{ $index }})">Remove Referee</x-buttons.secondary>
    </div>

</div>
