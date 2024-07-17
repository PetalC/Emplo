@props([
    'data',
    'label',
    'icon',
    'active' => false
])

<div>
    <div class="flex flex-col items-center gap-1">
        <div class="rounded-full border-2 border-gray-200 w-32 h-32 p-6 ">
            <x-dynamic-component component="icons.{{ $icon }}" class="text-gray-500" />
        </div>
        <span class="text-sm mt-2 font-bold text-center">{!! $data !!}</span>
        <span class="text-sm text-nowrap text-gray-500">{!! $label !!}</span>
    </div>
</div>
