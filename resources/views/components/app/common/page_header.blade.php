@props([
    'showDropdownMenu' => true,
    'mobileMenuSelectedIndex' => 0,
])
<div class="block mx-auto max-w-8xl w-full" >

    <div class="lg:grid lg:grid-cols-12">

        <div class="lg:col-span-2 flex flex-col items-center -translate-y-10">
            {{ $column_left ?? '' }}
        </div>

        <div  class="lg:hidden" x-data="{ showDropdownMenu: {{ $showDropdownMenu ? 'true' : 'false' }} }">
            <x-app.mobile-school-menu  x-show="showDropdownMenu" id="mobile_menu" name="mobile_menu" class="w-full" selectedIndex="{{ $mobileMenuSelectedIndex }}"/>
        </div>

        <div class="lg:col-span-8 flex flex-col gap-6 items-center pt-10">
            {{ $slot }}
        </div>

        <div class="lg:col-span-2">
            {{ $column_right ?? '' }}
        </div>

    </div>

</div>
