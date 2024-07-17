@props([
    'selectedIndex'
])
<div class="lg:hidden relative z-20 text-app h-20" x-data="{selectedItem:'{{ $selectedIndex }}', showDropdown:false, itemClicked : null}" x-init="
    itemClicked = function(itemNumber, url) {
        if(itemNumber != undefined){
            showDropdown=!showDropdown;
            if(!showDropdown)
            {
                selectedItem=itemNumber
                window.location.href=url
            }
        }
    }"
>
    <div class="w-full text-app text-3xl rounded-lg flex-col absolute bg-white border" :class="{ 'shadow-lg':showDropdown }">
        <div x-show="selectedItem==0 || showDropdown" x-on:click="itemClicked(0, '{{route('school.dashboard')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-chart-bar-square" class="w-8 h-8" />
            Dashboard
        </div>
        <div x-show="selectedItem==1 || showDropdown" x-on:click="itemClicked(1, '{{route('school.campuses')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-arrow-path" class="w-8 h-8" />
            Employer Profile
        </div>
        <div x-show="selectedItem==2 || showDropdown" x-on:click="itemClicked(2, '{{route('school.staffroom.candidates')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-user-group" class="w-8 h-8" />
            Staffroom Profile
        </div>
        <div x-show="selectedItem==3 || showDropdown" x-on:click="itemClicked(3, '{{route('school.jobcenter.index')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-megaphone" class="w-8 h-8" />
            Job Center
        </div>
        <div x-show="selectedItem==4 || showDropdown" x-on:click="itemClicked(4, '{{route('school.applicants')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-arrow-trending-up" class="w-8 h-8" />
            ATS
        </div>
        <div x-show="selectedItem==5 || showDropdown" x-on:click="itemClicked(5, '{{route('school.resources')}}')" class="flex items-center justify-center gap-5 w-full py-5 border-b">
            <x-icon name="heroicon-s-book-open" class="w-8 h-8" />
            Resource Library
        </div>
        <div x-show="selectedItem==6 || showDropdown" x-on:click="itemClicked(6, '')" class="flex items-center justify-center gap-5 w-full py-5">
            <x-icon name="heroicon-s-cog" class="w-8 h-8" />
            Setting
        </div>

        <div x-show="showDropdown" class="absolute right-8 top-5">
            <x-icon name="heroicon-o-chevron-up" class="w-8 h-8" />
        </div>
        <div x-show="!showDropdown" class="absolute right-8 top-5">
            <x-icon name="heroicon-o-chevron-down" class="w-8 h-8" />
        </div>
    </div>
</div>
