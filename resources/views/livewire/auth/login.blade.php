<div class="flex flex-col text-center gap-10 md:text-left" x-data="{ forgotten_password : false }">
    <h5 class="font-bold text-2xl">Login</h5>

    <div class="grid grid-cols-1 pl-20 pr-20 md:pr-0 md:pl-0 md:grid-cols-2 gap-5" wire:keydown.enter="login">

        <div x-bind:class="forgotten_password ? 'col-span-2' : ''">
            <x-input.outline
                x-cloak
                id="email"
                name="email"
                label="Email address"
                placeholder="Your email address"
                wire:model.blur="email"
            />
        </div>


        <div x-show="! forgotten_password">
            <x-input.outline
                x-cloak
                id="password"
                name="password"
                type="password"
                label="Password"
                placeholder="Your password"
                wire:model.blur="password"
            />
        </div>
    </div>

    <div class="flex items-center gap-10 flex-col justify-center md:flex-row md:justify-end mb-10">
        <a class="text-sm font-bold cursor-pointer hover:underline" x-cloak x-show="! forgotten_password" @click="forgotten_password = true">Forgotten your password?</a>
        <a class="text-sm font-bold cursor-pointer hover:underline" x-cloak x-show="forgotten_password" @click="forgotten_password = false">Remember your password?</a>

        <x-buttons.primary
            x-cloak
            x-show="! forgotten_password"
            size="lg"
            wire:click="login"
            wire:loading.attr="disabled"
        >
            <span wire:loading wire:target="login">Please Wait...</span>
            <span wire:loading.remove wire:target="login">Login</span>
        </x-buttons.primary>
        <x-buttons.primary
            x-cloak
            x-show="forgotten_password"
            size="lg"
            wire:click="reset_password"
            wire:loading.attr="disabled"
        >
            <span wire:loading wire:target="login">Please Wait...</span>
            <span wire:loading.remove wire:target="login">Reset Your Password</span>
        </x-buttons.primary>
    </div>
</div>
