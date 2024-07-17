@props([
    'showDropdownMenu' => true,
    'mobileMenuSelectedIndex' => 0,
])
{{-- Mobile Logo --}}
<div class="left-0 top-0 -translate-y-20 lg:hidden block w-full">
    <div class="relative pt-[100%]">
        <div class="absolute inset-0">
            <div class="w-full h-full rounded-lg overflow-hidden bg-white border border-gray-300 flex items-center justify-center">
                <img src="{{ asset('assets/app/school-1-logo.png') }}" class="w-64"/>
            </div>
        </div>
    </div> 
</div>

<div class="w-full mb-32 lg:hidden block"  x-data="{ showDropdownMenu: {{ $showDropdownMenu ? 'true' : 'false' }} }">
    <x-app.mobile-school-menu  x-show="showDropdownMenu" id="mobile_menu" name="mobile_menu" class="w-full" selectedIndex="{{ $mobileMenuSelectedIndex }}"/>
</div>
{{-- logo --}}
<div class="absolute top-0 left-20 -translate-y-20 lg:block hidden">
    <div class="flex flex-col gap-6">
        <div class="w-56 h-56 rounded-lg overflow-hidden bg-white border border-black flex items-center justify-center">
            <img src="{{ asset('assets/app/school-1-logo.png') }}" class="w-32"/>
        </div>
        {{ $slot ?? '' }}
    </div>
</div>