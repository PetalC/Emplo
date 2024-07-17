@props([
    'error' => null,
    'label' => null,
])

<div
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-on:change="value = $event.target.value"
    x-init="
        new Pikaday(
            { field: $refs.input, 'format': 'DD.MM.YYYY', firstDay: 1, toString(date, format) {
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
        {{ $attributes->whereDoesntStartWith('wire:model') }}
        x-ref="input"
        x-bind:value="value"
        type="text"
        class="block w-full shadow-sm sm:text-lg border-b-2 outline-none text-app border-black @if($error) focus:ring-danger-500 focus:border-danger-500 border-danger-500 text-danger-500 pr-10 @else focus:ring-primary-500 focus:border-primary-500 @endif"
    />
</div>
