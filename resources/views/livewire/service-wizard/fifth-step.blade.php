<div>
    <p class="text-3xl text-center mt-5">We believe in try before you buy. Your one-month free trial includes all the features.<br/> It commences when you post your first job. Based on your input, we recommend the following package:</p>

    <div class="grid grid-cols-3 gap-10 mt-5" x-data="{active: 1}">
        <div :class="{'opacity-40':active != 1, 'mt-6':active == 1}" x-on:click="active=1">
            <p class="mb-2 text-2xl text-center">Attract</p>
            <div class="border rounded-lg border-primary py-5 text-app">
                <p class="text-center text-xl"> Recruit:365</p>
                <p class="text-center text-xl text-primary"> Jon Center</p>
                <p class="text-center text-xl text-primary"> Staffroom</p>
                <p class="text-center text-xl text-primary"> Multi-User</p>
                <p class="text-center text-xl"> Complimentary Set-Up</p>
            </div>
        </div>
        <div :class="{'opacity-40':active != 2, 'mt-6':active == 2}" x-on:click="active=2">
            <p class="mb-2 text-2xl text-center">Enhance</p>
            <div class="border rounded-lg border-primary py-5 text-app">
                <p class="text-center text-xl"> Recruit:365</p>
                <p class="text-center text-xl"> Jon Center</p>
                <p class="text-center text-xl text-primary"> Staffroom</p>
                <p class="text-center text-xl text-primary"> Resource Library</p>
                <p class="text-center text-xl text-primary"> ATS</p>
                <p class="text-center text-xl text-primary"> 4 Paid Social</p>
                <p class="text-center text-xl text-primary"> Boosters</p>
                <p class="text-center text-xl text-primary"> 27 Advertising</p>
                <p class="text-center text-xl text-primary"> Credits</p>
                <p class="text-center text-xl"> Multi-User</p>
                <p class="text-center text-xl"> Complimentary Set-Up</p>
            </div>
        </div>
        <div :class="{'opacity-40':active != 3, 'mt-6':active == 3}" x-on:click="active=3">
            <p class="mb-2 text-2xl text-center">Safeguard</p>
            <div class="border rounded-lg border-primary py-5 text-app">
                <p class="text-center text-xl"> Recruit:365</p>
                <p class="text-center text-xl"> Jon Center</p>
                <p class="text-center text-xl"> Staffroom</p>
                <p class="text-center text-xl"> Resource Library</p>
                <p class="text-center text-xl"> ATS</p>
                <p class="text-center text-xl text-primary"> 4 Paid Social</p>
                <p class="text-center text-xl text-primary"> Boosters</p>
                <p class="text-center text-xl text-primary"> 27 Advertising</p>
                <p class="text-center text-xl text-primary"> Credits</p>
                <p class="text-center text-xl text-primary"> Multi-User</p>
                <p class="text-center text-xl"> Complimentary Set-Up</p>
            </div>
        </div>
    </div>

    <div class="mt-5 flex justify-center">
        <x-button.primary> Free Sign Up</x-button.primary>
    </div>
    <div class="mt-5 flex justify-center gap-5">
        <x-button.primary> Email Quoate</x-button.primary>
        <x-button.primary> Book A Demo</x-button.primary>
        <x-button.primary wire:click="updateParentValue(7)"> Maybe Later</x-button.primary>
        <x-button.primary wire:click="updateParentValue(6)"> No</x-button.primary>
    </div>

</div>
