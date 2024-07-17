<div>
    <div  class="fixed w-full h-screen left-0 top-0 bg-black/30 z-[3]"></div>
    <x-dialog x-on:click.away="openWizard = false" class="flex-col justify-between p-10 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[4] w-3/5 min-h-[40rem]">
        <div class="flex h-32 justify-between w-full items-center text-app" x-data>
            <div class="flex items-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 mr-5 flex items-center justify-center text-app">
                    <x-icon name="heroicon-o-user" class="w-24 h-24" />
                </div>
                Welcome!
            </div>
            <div class="w-1/3">
                <x-app.service-wizard.progress-bar  progress="{{ $this->progress }}"/>
            </div>
            <div>
                <x-button.outline>Go straight to signup</x-button.outline>
            </div>
        </div>
        <div class="flex-grow flex justify-center items-center"  >
            @if ($this->step == 1)
                <livewire:service-wizard.first-step />
            @elseif($this->step == 2)
                <livewire:service-wizard.second-step />
            @elseif($this->step == 3)
                <livewire:service-wizard.third-step />
            @elseif($this->step == 4)
                <livewire:service-wizard.forth-step />
            @elseif($this->step == 5)
                <livewire:service-wizard.fifth-step />
            @elseif($this->step == 6)
                <livewire:service-wizard.fifth-step-A />
            @elseif($this->step == 7)
                <livewire:service-wizard.fifth-step-B />
            @endif

        </div>
    </x-dialog>
</div>