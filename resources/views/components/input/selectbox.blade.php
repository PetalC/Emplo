@props([
    'id',
    'name',
    'options' => [],
    'prefix' => '',
])

<div class="flex w-full">
    <div class="text-gray-600 h-14 bg-transparent text-sm outline-none border-l-2 border-t-2 border-b-2 border-grey rounded-tl-lg rounded-bl-lg flex items-center justify-center pl-5 text-nowrap">{{ $prefix . ":"}}</div>
    <select
        {{ $attributes->merge(['class' => 'w-full font-bold px-5 text-gray-600 h-14 bg-transparent text-sm block outline-none border-t-2 border-b-2 border-r-2 border-grey placeholder-secondary/80 rounded-tr-lg rounded-br-lg']) }}
    >
        @foreach($options as $value => $option )
            <option value="{{ $value }}">{{ $option }}</option>
        @endforeach
    </select>
</div>
