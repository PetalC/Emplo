@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
])

<div class="max-w-5xl mx-auto py-12 divide-y">

    <p class="font-bold mb-10">Experience</p>

    @forelse( $user->experiences as $experience )
        <div class="py-12">

            <h5 class="text-3xl !mb-4 font-light">{{ $experience->company }}</h5>

            <div class="flex gap-4 items-center">
                <x-badge>{{ $experience->role }}</x-badge>
                <div class="flex gap-2">
                    <x-icon name="heroicon-o-clock" class="w-5 h-5 text-gray-400" />
                    <span>{{ $experience->started_at->format('M Y') }} - {{ $experience->ended_at?->format('M Y') ?? 'Present' }}</span>
                </div>
            </div>

            <div class="mt-6">
                <p>{!!  $experience->story !!}</p>
            </div>

        </div>
    @empty
        <p>This user has not added any experience to their profile.</p>
    @endforelse

</div>
