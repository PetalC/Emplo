<div class="w-full lg:w-[50%] flex justify-between m-auto border-b-[1px] border-gray-300 pt-10 pb-10">
    <div class="flex flex-col items-start justify-center gap-3">
        <p class="text-lg lg:text-3xl text-gray-700">{{ $setting['name'] }}</p>
        <p class="text-sm lg:text-lg text-gray-500">{{ $setting['desc'] }}</p>
    </div>
    <x-buttons.secondary
        class="text-lg lg:text-xl px-4 lg:px-8 {{ isset($setting['disabled']) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : '' }}"
        @click.prevent="$wire.dispatch('settings.open-modal', ['{{ $setting['slug'] }}'])"
        :disabled="isset($setting['disabled'])"
        x-data="{
        isDisabled: ['employer-logo', 'employer-gallery'].includes('{{ $setting['slug'] }}')
    }"
        x-bind:class="{ 'bg-gray-300 text-gray-500 cursor-not-allowed': isDisabled }"
        x-on:click="if(isDisabled) { return false; }"
    >
        {{ __('Update') }}
    </x-buttons.secondary>
</div>
