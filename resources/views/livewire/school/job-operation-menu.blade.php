<div class="lg:hidden block" x-data="{showDropdown:false}">
    <div x-on:click="showDropdown=true" class="flex items-center justify-center gap-5 w-full py-5 border-b text-app text-3xl border rounded-lg">
        @if($this->selectedItem == 0)
        <div class="flex gap-5 items-center">
            <x-icon name="heroicon-o-wrench-screwdriver" class="w-8 h-8" />
            Options
        </div>
        @elseif($this->selectedItem == 1)
        <div class="flex gap-5 items-center">
            <x-icons.check-box /> 
            Select all
        </div>
        @elseif($this->selectedItem == 2)
        <div class="flex gap-5 items-center">
            <x-icons.uncheck-box /> 
            Unselect all
        </div>
        @elseif($this->selectedItem == 3)
        <div class="flex gap-5 items-center">
            <x-icons.plus /> 
            Create New Ad
        </div>
        @elseif($this->selectedItem == 4)
        <div class="flex gap-5 items-center">
            <x-icon name="heroicon-o-clipboard-document" class="w-6 h-6" />
            Clone Job
        </div>
        @elseif($this->selectedItem == 5)
        <div class="flex gap-5 items-center">
            <x-icons.x-mark /> 
            Remove Ad
        </div>
        @endif
        <div class="absolute right-28">
            <x-icon name="heroicon-o-chevron-down" class="w-8 h-8" />
        </div>
    </div>
    <x-dialog x-show="showDropdown" x-on:click="showDropdown=false" class="w-[calc(100%-10rem)] text-app text-3xl rounded-lg flex-col absolute -mt-20">
        <div wire:click="selectItem(0)" class="flex items-center justify-center gap-5 w-full py-5 border-b opacity-40">
            <x-icon name="heroicon-o-wrench-screwdriver" class="w-8 h-8" />
            Options
            <div class="absolute right-8">
                <x-icon name="heroicon-o-chevron-up" class="w-8 h-8" />
            </div>
        </div>
        <div wire:click="selectItem(1)" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icons.check-box /> 
            Select all
        </div>
        <div wire:click="selectItem(2)" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icons.uncheck-box /> 
            Unselect all
        </div>
        <div wire:click="selectItem(3)" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icons.plus /> 
            Create New Ad
        </div>
        <div wire:click="selectItem(4)" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-o-clipboard-document" class="w-6 h-6" />
            Clone Job
        </div>
        <div wire:click="selectItem(5)" class="flex items-center justify-center gap-5 w-full py-5">
            <x-icons.x-mark /> 
            Remove Ad
        </div>
    </x-dialog>
</div>
