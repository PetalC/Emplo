@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
])
@php
$data = $user->sg_data;
@endphp

<div class="max-w-5xl mx-auto py-12">

    <p class="font-bold mb-10">Safe Guarding Indicators</p>

    <div class="flex justify-between gap-4 items-center">

        <div class="flex gap-2 items-center">
            <x-app.safeguard-badge class="!w-16 !h-16 !text-xl !font-normal" icon_class="!w-16 !h-16" :verified="$data['suitability_declared']" :label="'SD'" />
            <span class="text-sm">Suitability<br />Declaration</span>
        </div>

        <div class="flex gap-2 items-center">
            <x-app.safeguard-badge class="!w-16 !h-16 !text-xl !font-normal" icon_class="!w-16 !h-16" :verified="$data['references_supplied']" :label="'R'" />
            <span class="text-sm">References<br />Supplied</span>
        </div>

        <div class="flex gap-2 items-center">
            <x-app.safeguard-badge class="!w-16 !h-16 !text-xl !font-normal" icon_class="!w-16 !h-16" :verified="$data['teaching_registration_verification']" :label="'TR'" />
            <span class="text-sm">Teaching Registration<br />Verification</span>
        </div>

        <div class="flex gap-2 items-center">
            <x-app.safeguard-badge class="!w-16 !h-16 !text-xl !font-normal" icon_class="!w-16 !h-16" :verified="$data['identity_verification']" :label="'ID'" />
            <span class="text-sm">Identity<br />Verification</span>
        </div>

        <div class="flex gap-2 items-center">
            <x-app.safeguard-badge class="!w-16 !h-16 !text-xl !font-normal" icon_class="!w-16 !h-16" :verified="$data['ancc_check']" :label="'CC'" />
            <span class="text-sm">Australian National<br />Character Check</span>
        </div>

    </div>

</div>
