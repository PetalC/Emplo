@props([
    'type' => 'primary',
    'job'
])
{{-- apply --}}
<div {{ $attributes->merge(['class' => 'flex']) }}>
    @if( $job->routing_preference && $job->routing_preference != \App\Enums\ApplicationRoutingPreferenceTypes::EMPLOYO->value )
        @if($type === 'primary')
            <x-buttons.primary elem_type="link" :shadow="false" class="w-full whitespace-nowrap" wire:click.stop="" href="{{ $job->external_application_url }}">Apply now</x-buttons.primary>
        @else
            <x-buttons.secondary elem_type="link" href="{{ $job->external_application_url }}" :shadow="false" wire:click.stop="" class="whitespace-nowrap">Apply now</x-buttons.secondary>
        @endif
    @else
        @if( $type === 'primary' )
            <x-buttons.primary elem_type="link" :shadow="false" class="w-full whitespace-nowrap" href="{{ route('job.apply', $job ) }}">Apply now</x-buttons.primary>
        @else
            <x-buttons.secondary elem_type="link" :shadow="false" class="whitespace-nowrap"  href="{{ route('job.apply', $job ) }}">Apply now</x-buttons.secondary>
        @endif
    @endif
</div>
