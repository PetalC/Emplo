@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
])

<div class="max-w-5xl mx-auto py-12 divide-y">

    <p class="font-bold mb-10">Education</p>

    @forelse( $user->educations as $education )
        <div class="py-12">

            <h5 class="text-3xl !mb-4 font-light">{{ $education->school }}</h5>

            <div class="flex gap-4 items-center">
                <x-badge>{{ $education->degree }}</x-badge>
                <div class="flex gap-2">
                    <x-icon name="heroicon-o-clock" class="w-5 h-5 text-gray-400" />
                    <span>{{ $education->sterted_at?->format('M Y') }} - {{ $education->ended_at?->format('M Y') ?? 'Present' }}</span>
                </div>
            </div>

            <div class="mt-6">
                <p>{{ $education->story }}</p>
            </div>

        </div>
    @empty
        <p>This user has not added any education to their profile.</p>
    @endforelse

</div>
