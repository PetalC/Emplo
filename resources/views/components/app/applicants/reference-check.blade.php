@php use App\Enums\ApplicationReferenceCheckStatuses; @endphp
<div class="border border-gray-200 rounded-lg flex mx-20 mt-12">
    <div class="grid grid-cols-4 content-center items-center justify-items-center">
        <x-icon name="heroicon-s-user" class="h-auto max-w-full text-gray-300 md:row-span-2"/>
        <span>
            {{ $referenceCheck->referee->name }}
        </span>
        <span>
            {{ $referenceCheck->referee->position }}
        </span>
        <span class="flex flex-row">
            @switch($referenceCheck->status)
                @case(ApplicationReferenceCheckStatuses::INTRO)
                    <a href="{{ route('school.applicants.reference.check', $referenceCheck) }}">
                        <x-button.outline
                            class="bg-gray-200 rounded flex flex-row items-center gap-1 text-gray-800 cursor-pointer">
                            <x-icon name="heroicon-o-pencil" class="w-4 h-4"/>
                            <span class="underline">Check</span>
                        </x-button.outline>
                    </a>
                    @break
                @case(ApplicationReferenceCheckStatuses::COMPLETED)
                    <x-icons.check-mark/>
                    <x-badge class="!px-2 !py-1 text-xs mt-1" variant="success">Completed</x-badge>
                    @break
                @default
                    {{ $referenceCheck->status }}
            @endswitch
        </span>
        @if($referenceCheck->comment)
            <span class="col-start-2 col-span-3 text-gray-500">
            {{ $referenceCheck->comment }}
        </span>
        @endif
    </div>
</div>
