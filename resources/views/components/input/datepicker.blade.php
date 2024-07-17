@props([
    'id',
    'name',
    'label' => '',
    'disabled' => false,
    'placeholder' => '',
    'rows' => 3,
])

@php
if( $attributes->has( 'wire:model') ){
    $error = $errors->has( $attributes->get( 'wire:model') );
} else {
    $error = false;
}
@endphp

<div class="flex flex-col" wire:loading.class="opacity-50" wire:target="{{ $attributes->wire('model')->value() }}">
    <!-- label -->
    @if($label)
    <div class="flex justify-between">
        <label class="block mb-2 text-sm font-bold text-secondary @if($error) !text-danger @endif">{{ $label }}</label>
    </div>
    @endif

    <div
        x-data="{ value: @entangle($attributes->wire('model')) }"
        x-on:change="value = $event.target.value"
        x-init="
        new Pikaday(
            { field: $refs.input, 'format': 'DD.MMMM.YYYY', firstDay: 1, toString(date, format) {
                    // you should do formatting based on the passed format,
                    // but we will just return 'D/M/YYYY' for simplicity
                    const day = date.getDate();
                    const month = date.getMonth() + 1;
                    const year = date.getFullYear();
                    return `${day}/${month}/${year}`;
                },
                parse(dateString, format) {
                    // dateString is the result of `toString` method
                    const parts = dateString.split('/');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1;
                    const year = parseInt(parts[2], 10);
                    return new Date(year, month, day);
                }
        });"
    >
        <input
            {{ $attributes->whereDoesntStartWith('wire:model')->merge( [ 'class' => 'h-10 block w-full shadow-sm border-b-2 outline-none text-app border-gray-800' ] ) }}
            x-ref="input"
            x-bind:value="value"
            type="text"
        />
    </div>
</div>
