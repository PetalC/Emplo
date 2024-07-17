@props( [
'selected' => false,
'follower'
] )

<div class="flex flex-col xl:flex-row xl:justify-between xl:items-center items-center border rounded-lg px-8 pb-8 xl:pb-0 {{ $selected ? 'border-2 border-green-600 bg-green-50' : 'border-gray-200' }}">

    <div class="py-4 xl:w-[40px]">
        <x-input.checkbox :checked="$selected" id="test" />
    </div>
    <div class="py-4 pr-4 xl:border-r xl:border-r-gray-200 xl:pr-8 xl:w-[160px]">
        {{  $follower->user->email }}
        <x-icon name="heroicon-o-exclamation-circle" class="inline-block -translate-y-[1px] w-5 h-5" />
        <div class="text-gray-400">5.2km Away</div>
    </div>
    <div class="xl:w-[160px]">
        <x-select.dropdown label="LE" class="rounded text-black p-2">
            <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
            <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
            <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
        </x-select.dropdown>
        <x-select.dropdown label="TI" class="rounded text-blac p-2">
            <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
            <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
            <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
        </x-select.dropdown>
        <x-select.dropdown label="SR" class="bg-success rounded text-white p-2">
            <x-buttons.primary class="justify-center">Yes</x-buttons.primary>
            <x-buttons.secondary class="justify-center">No</x-buttons.secondary>
            <x-buttons.danger class="justify-center">Flag</x-buttons.danger>
        </x-select.dropdown>
    </div>

    <x-app.user.badges :user="$follower->user" />

</div>
