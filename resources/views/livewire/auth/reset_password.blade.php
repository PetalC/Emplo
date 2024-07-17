<div class="max-w-8xl mx-auto flex flex-col text-secondary">
    <div class="flex flex-col items-center gap-20">
        <div class="h-24">
            <x-app.logo.logo />
        </div>

        <div class="flex flex-col w-full items-center divide-y divide-y-b">
            {{-- section 1: Login --}}
            <div class="grid grid-cols-4 gap-10 w-full">
                <x-text.heading variant="h1" class="text-center col-span-12 inline sm:hidden">
                    Reset your <span class="text-primary">password</span>
                </x-text.heading>
                <div class="col-span-12 md:col-span-1">
                    <img src="{{ asset('assets/app/auth-banner.png') }}" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-2">
                    <div class="flex flex-col gap-14">
                        <x-text.heading variant="h1" class="hidden sm:inline text-center">
                            Reset your <span class="text-primary">password</span>
                        </x-text.heading>

                        <div class="flex flex-col text-center gap-10 md:text-left" x-data="{ forgotten_password : false }">
                            <h5 class="font-bold text-2xl">Reset Your Password</h5>

                            <div class="grid grid-cols-1 pl-20 pr-20 md:pr-0 md:pl-0 md:grid-cols-2 gap-5" wire:keydown.enter="login">

                                <div>
                                    <x-input.outline
                                        id="password"
                                        name="password"
                                        type="password"
                                        label="Your New Password"
                                        placeholder="Your password"
                                        wire:model.blur="password"
                                    />
                                </div>


                                <div>
                                    <x-input.outline
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        label="Confirm your password"
                                        placeholder="Confirm your password"
                                        wire:model.blur="password_confirmation"
                                    />
                                </div>
                            </div>

                            <div class="flex items-center gap-10 flex-col justify-center md:flex-row md:justify-end">

                                <x-buttons.primary
                                    size="lg"
                                    wire:click="handle_reset"
                                    wire:loading.attr="disabled"
                                >
                                    <span wire:loading wire:target="login">Please Wait...</span>
                                    <span wire:loading.remove wire:target="login">Reset</span>
                                </x-buttons.primary>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


