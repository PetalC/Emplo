@props([
    'application'
])
<div x-data="{ showReviewerFlagConfirmation: [] }">
    @if(!empty($reviewers))
        @foreach($reviewers as $reviewer)
            @if( $reviewer->is( auth()->user() ) )
                <x-select.dropdown label="{{ $this->getInitials($reviewer) }}" class="{{ $this->getReviewClasses($reviewer) }} rounded p-2">
                    <x-buttons.primary :shadow="false" class="justify-center" wire:click.defer="approve">Yes</x-buttons.primary>
                    <x-buttons.secondary class="justify-center" wire:click.defer="decline">No</x-buttons.secondary>
                    <x-buttons.danger class="justify-center" @click="showReviewerFlagConfirmation.push('{{ $reviewer->id }}')">Flag</x-buttons.danger>
                </x-select.dropdown>
            @else
                <span class="{{ $this->getReviewClasses($reviewer) }} rounded p-2">{{ $this->getInitials($reviewer) }}</span>
            @endif
        {{-- @Nate - Merge conflict - unsure about flaggable, need to dig into it --}}
{{--            @if($this->isFlaggable())--}}
            <x-modal x-show="showReviewerFlagConfirmation.includes('{{ $reviewer->id }}')"
                     x-on:click.outside="showReviewerFlagConfirmation.pop('{{ $reviewer->id }}')"
                     onClose="showReviewerFlagConfirmation.pop('{{ $reviewer->id }}')"
                     :application="$application">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="confirmation-title">
                            You are about to flag {{ $application->user->name }}
                        </h3>
                        <div class="mt-2">
                            <div>
                                <p>This means that there will be <span class="font-bold">permanent red flag against their profile</span> in the
                                    system so that they will not be hired.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button @click="$wire.$call('flagApplicant'); showReviewerFlagConfirmation.pop('{{ $reviewer->id }}')" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                        Proceed
                    </button>
                    <button @click="showReviewerFlagConfirmation.pop('{{ $reviewer->id }}')" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </x-modal>
            {{-- @Nate - Merge conflict - unsure about flaggable, need to dig into it --}}
            {{--            @endif--}}
        @endforeach
    @else
        N/A
    @endif
</div>
