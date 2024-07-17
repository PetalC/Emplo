@php use App\Enums\MediaCollections; @endphp
<div x-data="{ openDocuments : false }">
    <div class="flex items-center gap-2 cursor-pointer" @click="openDocuments = true">
        <div class="bg-gray-200 text-black p-1 rounded">
            <x-icon name="heroicon-o-bars-3" class="w-4 h-4 text-gray-800"/>
        </div>
        @if($mediaCollection)
            <span class="underline">{{ count($mediaCollection) }} Docs</span>
        @else
            <span class="underline">0 Docs</span>
        @endif
    </div>
    {{-- document view modal --}}
    <x-modal
        x-show="openDocuments"
{{--        x-on:click.outside="openDocuments = false"--}}
        onClose="openDocuments = false"
        x-cloak
    >
        <div class="flex flex-col gap-6 items-center">
            <h5 class="text-2xl">Documents</h5>
            @foreach($mediaCollection as $media)
                <x-app.user.document :user="$application->user" :media="$media"/>
            @endforeach

            <div>
                <x-input.upload class="border-none" label="Supporting Documents" id="upload_file_{{ $application->id }}" accept="*" wire:model.live="uploadFile">
                    <x-button.outline>Add document</x-button.outline>
                </x-input.upload>
            </div>

            <x-buttons.primary class="mt-6" @click="openDocuments = false" size="xl">Done</x-buttons.primary>
        </div>
    </x-modal>

</div>
