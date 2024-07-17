@props([
    'stepperPrefix'
])
<div>

    <x-dynamic-component :component="job.application.steps.' . strtolower( $active_component->type )" :step="$active_component" />

    <div class="p-4 border-t bg-theme-light flex justify-between items-center">

        <div>
            @if( $current_component > 1 )
                <x-button.secondary wire:click="previousComponent">Previous Step:</x-button.secondary>
            @endif
        </div>

        <div>
            @if( $current_component < $workflow->components->count() )
                <x-button.primary wire:click="nextComponent">Next Step:</x-button.primary>
            @endif
        </div>

    </div>

</div>
