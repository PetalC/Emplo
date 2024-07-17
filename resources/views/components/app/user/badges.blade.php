@props([
    'user'
])
@php
$data = $user->sg_data;
@endphp
<div class="mt-5 xl:mt-0 xl:w-[180px]">
    <div class="flex gap-2 items-center">
        <x-app.safeguard-badge :verified="$data['suitability_declared']" :label="'SD'" />
        <x-app.safeguard-badge :verified="$data['references_supplied']" :label="'R'" />
        <x-app.safeguard-badge :verified="$data['teaching_registration_verification']" :label="'TR'" />
        <x-app.safeguard-badge :verified="$data['identity_verification']" :label="'ID'" />
        <x-app.safeguard-badge :verified="$data['ancc_check']" :label="'CC'" />
    </div>
</div>
