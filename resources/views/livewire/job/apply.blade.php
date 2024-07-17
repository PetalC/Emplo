{{--<div class="flex flex-col p-6 gap-10 justify-center items-center text-center md:grid md:grid-cols-12">--}}
{{--    <div class="flex flex-col gap-10 justify-center md:col-start-2 md:col-span-10 md:border-3 md:border-red-600 md:rounded p-5">--}}

{{--       --}}
{{--    </div>--}}
{{--</div>--}}
<div class="p-20 mb-20 border rounded-2xl">

    <nav aria-label="Progress" class="pb-20 mt-6">
        <ol role="list" class="flex items-center justify-center">

            @foreach ($steps as $step)
                @php
                    $active = $loop->index == $this->current_step();
                    $completed = $loop->index < $this->current_step();
                @endphp
                <li class="relative {{ $loop->last ? '' : 'pr-8 sm:pr-60' }}">
                    @if($completed)

                        <!-- Completed Step -->
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="h-1 w-full bg-primary"></div>
                        </div>
                        <div class="relative">
                            <a wire:click="setStep('{{$step}}')" class="cursor-pointer relative flex items-center justify-center rounded-full bg-primary hover:opacity-95">
                                <span class="h-5 w-5 rounded-full bg-primary" aria-hidden="true"></span>
                            </a>
                            <span class="absolute top-[100%] left-1/2 translate-y-3 -translate-x-1/2 text-app text-sm">{{ \Illuminate\Support\Str::title( $step ) }}</span>
                        </div>


                    @elseif( $active )

                        <!-- Current Step -->
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="h-1 w-full bg-gray-200"></div>
                        </div>
                        <div class="relative">
                            <a class="relative flex items-center justify-center rounded-full" aria-current="step">
                                <span class="h-5 w-5 rounded-full bg-primary" aria-hidden="true"></span>
                                <span class="sr-only">{{ \Illuminate\Support\Str::title( $step ) }}</span>
                            </a>
                            <span class="absolute top-[100%] left-1/2 translate-y-3 -translate-x-1/2 text-app text-sm">{{ \Illuminate\Support\Str::title( $step ) }}</span>
                        </div>

                    @else

                        <!-- Upcoming Step -->
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="h-1 w-full bg-gray-200"></div>
                        </div>
                        <div class="relative">
                            <a wire:click="setStep('{{$step}}')" class="cursor-pointer group relative flex items-center justify-center rounded-full bg-white">
                                <span class="h-5 w-5 rounded-full bg-gray-300" aria-hidden="true"></span>
                                <span class="sr-only">{{ \Illuminate\Support\Str::title( $step ) }}</span>
                            </a>
                            <span class="absolute top-[100%] left-1/2 translate-y-3 -translate-x-1/2 text-app text-sm">{{ \Illuminate\Support\Str::title( $step ) }}</span>
                        </div>

                    @endif

                </li>

            @endforeach

        </ol>
    </nav>

    <div>
        @switch( $current_component )
            @case( 'criteria' )
                <livewire:job.application.user-details :job="$job" :user="$user" wire:model.live="application" />
                @break
            @case( 'documents' )
                <livewire:job.application.documents :job="$job" :user="$user" wire:model.live="application" />
                @break
            @case( 'reviews' )
                <livewire:job.application.review :job="$job" :user="$user" wire:model="application" />
                @break
            @case( 'complete' )
                <livewire:job.application.complete :job="$job" :user="$user" wire:model="application" />
                @break
        @endswitch
    </div>

</div>
