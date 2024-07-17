@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
])

<div class="max-w-5xl mx-auto py-12 divide-y">

    <p class="font-bold mb-10">Certifications</p>

    @forelse( $user->profile_certifications as $certification )
        <div class="py-12">

            <h5 class="text-3xl !mb-4 font-light">{{ $certification->institution }}</h5>

            <div class="flex gap-4 items-center">
                <x-badge variant="success">{{ $certification->certification }}</x-badge>
                <div class="flex gap-2">
                    <x-icon name="heroicon-o-clock" class="w-5 h-5 text-gray-400" />
                    <span>{{ $certification->completed_at->format('M Y') }}</span>
                </div>
            </div>

        </div>
    @empty
        <p>This user has not added any certifications to their profile.</p>
    @endforelse

</div>
