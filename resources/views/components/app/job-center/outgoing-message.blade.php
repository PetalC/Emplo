@props([
    'label',
    'name',
    'time'
])

<div class="flex lg:flex-row flex-col-reverse lg:items-center gap-5 lg:justify-end items-end">
    <div class="text-app lg:mr-0 mr-20">
        {{ $time }}
    </div>
    <div class="flex gap-5">
        <div class="flex">
            <div class="bg-sky-500 text-white px-5 py-2 rounded-lg w-fit">
                {{ $label }}
            </div>
            <div class="w-5 overflow-hidden inline-block">
                <div class="-translate-x-[4px] h-12  bg-sky-500 text-white rotate-45 transform origin-top-left"></div>
            </div>
        </div>
        <div class="w-10 h-10 p-5 rounded-full bg-sky-500 text-white flex items-center justify-center">
            {{ $name }}
        </div>
    </div>
</div>
