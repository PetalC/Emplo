<div>

    <div class="grid grid-cols-12 gap-y-5 my-20 px-6 3xl:px-0" wire:loading.class="opacity-25">

        @forelse( $applications as $application )
            @if( $application->job )
                <livewire:profile.application-card :application="$application" :key="'application_' . $application->id"/>
            @endif
        @empty
            <h3 class="text-4xl font-light text-center col-span-12">
                You do not have applications. Please <a href="{{ route('search') }}" class="text-primary">search for jobs</a> to apply.
            </h3>
        @endforelse

    </div>

</div>
