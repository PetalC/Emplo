@props([
    'icon',
    'disabled' => false
])
<div class="flex gap-5 items-center {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
    <x-input.checkbox :display_errors="false" :disabled="$disabled" {{ $attributes }} />
    <img src="{{ asset('assets/app/sites/' . $icon . '-icon.svg') }}" class="w-12 h-12 object-contain" />
    {{ $slot ?? '' }}
</div>
