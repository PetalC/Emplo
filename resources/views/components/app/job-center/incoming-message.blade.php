@props([
    'label',
    'name',
    'time'
])

<div class="flex lg:flex-row flex-col lg:items-center gap-5">
    <div class="flex gap-5">
        <div class="w-10 h-10 p-5 rounded-full bg-gray-100 flex items-center justify-center">
            {{ $name }}
        </div>
        <div class="flex w-full">
            <div class="w-5 overflow-hidden inline-block">
                <div class="translate-x-1 h-11  bg-gray-100 -rotate-45 transform origin-top-right rounded-sm"></div>
            </div>
            <div class="bg-gray-100 px-5 py-2 rounded-lg w-fit">
                {{ $label }}
            </div>
        </div>
    </div>
    <div class="text-app lg:ml-0 ml-20">
        {{ $time }}
    </div>
</div>
