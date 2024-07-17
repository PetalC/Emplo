<div class="flex flex-row gap-3">
{{--    @if($application->interviews->isEmpty())--}}
{{--        N/A--}}
{{--        <x-button.outline wire:click="$parent.scheduleInterview"--}}
{{--            fullWidth="true"--}}
{{--            class="flex flex-col cursor-pointer items-center">--}}
{{--            <x-icons.calendar />--}}
{{--            Book--}}
{{--        </x-button.outline>--}}
{{--    @else--}}
{{--        29 Feb <a href="" class="underline">Notes</a>--}}
{{--    @endif--}}

        @if($application->interview)
            {{ Carbon\Carbon::parse($application->interview->scheduled_at)->format('j M') }} <a href="" class="underline opacity-40 cursor-not-allowed">Notes</a>
        @else
            N/A
        @endif
</div>
