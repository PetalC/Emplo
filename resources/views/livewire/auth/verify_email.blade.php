<div class="max-w-8xl mx-auto flex flex-col text-secondary">
    <div class="flex flex-col items-center gap-20">
        <div class="h-24">
{{--            <x-app.logo.logo />--}}
        </div>

        <div class="flex flex-col w-full items-center divide-y divide-y-b">
            {{-- section 1: Login --}}
            <div class="grid grid-cols-4 gap-10 w-full">
                <x-text.heading variant="h1" class="text-center col-span-12 inline sm:hidden">
                    Verify your <span class="text-primary">email</span>
                </x-text.heading>
                <div class="col-span-12 md:col-span-1">
                    <img src="{{ asset('assets/app/auth-banner.png') }}" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-2">
                    <div class="flex flex-col gap-14">
                        <x-text.heading variant="h1" class="hidden sm:inline text-center">
                            Verify your <span class="text-primary">email</span>
                        </x-text.heading>

                        <div class="flex flex-col text-center gap-6">
                            <h5 class="font-bold text-2xl">Please verify your email to continue.</h5>

                            <p>A verification email has been sent to your email address.<br />Please click the link in the email to verify your email address.</p>

                            <p>If you did not receive the email, please click <a class="underline cursor-pointer" wire:click="resend_verification">here</a> to request another email.</p>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
