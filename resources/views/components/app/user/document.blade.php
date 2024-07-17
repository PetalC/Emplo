<div>
    @php
    $url = ( env( 'APP_ENV' ) == 'local' ) ? $media->geturl() : $media->getTemporaryUrl( \Carbon\Carbon::now()->addMinutes( 5 ) );
    @endphp
    <div class="border border-gray-200 rounded-lg flex justify-center mx-10 mt-12 py-4 min-w-[550px]">
        <div class="flex items-center justify-center gap-6">
            <!-- Icon -->
            <x-icon name="heroicon-s-document-text" class="w-10 h-10 text-gray-300"/>

            <!-- File name and Internal Upload -->
            <div class="flex flex-col items-center">
                <span>{{ $media->file_name }}</span>
               <span>Created: {{$media->created_at->toDateString() }}</span>
                @if($media->hasCustomProperty('internalUpload'))
                    <span>Internal Upload</span>
                @endif
            </div>

            <!-- Download button -->
            <x-button.outline
                class="bg-gray-200 rounded flex items-center gap-1 text-gray-800 cursor-pointer mx-4 px-4 py-2">
                <x-icon name="heroicon-o-arrow-down-tray" class="w-4 h-4"/>
                <a class="underline" href="{{ $url }}" target="_blank">Download</a>
            </x-button.outline>

            @if($media->getCustomProperty('uploadedBy') == Auth::id())
                <x-button.outline
                    class="bg-red-200 rounded flex items-center justify-center text-gray-800 cursor-pointer mx-4 px-4 py-2"
                    wire:click="removeDocument({{ $media->id }})">
                    <x-icon name="heroicon-o-trash" class="w-4 h-4"/>
                </x-button.outline>
            @endif
        </div>
    </div>

</div>
