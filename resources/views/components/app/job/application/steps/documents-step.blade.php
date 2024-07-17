@php use App\Enums\MediaCollections; @endphp
@props(['job', 'references', 'min_references', 'documents', 'school_documents' ] )
<div class="grid grid-cols-4 w-full">
    <div class="col-start-1 col-span-12 pr-5 pl-5 md:pl-0 md:pr-0 md:col-start-1 md:col-span-4 flex flex-col gap-10">
        <div class="flex flex-col gap-x-5 align-middle">
            <h4 class="text-app text-xl mb-8 text-center"><span class="font-bold">{{ $job->school->name }}</span> requires the following information be supplied for this position</h4>
            <div class="flex flex-col items-center md:justify-between md:flex-row py-4 border-y border-y-gray-400">
                <h3><span class="font-bold">Resume</span> and any additional documents</h3>
                <div>
                    <x-input.upload class="w-24 flex justify-center item-center" id="document_upload" wire:model.live="document_upload" />
                </div>
            </div>
            <div class="grid grid-cols-4 gap-y-2 items-center w-full">

                @foreach( $documents as $index => $document )
                    <div class="py-2 border-b border-b-gray-200 col-span-4 flex gap-2 justify-between items-center">
                        <div class="col-start-1 col-span-2 p-2">
                            <h4>{{ $document->file_name }}</h4>
                        </div>
                        <div class="col-start-3 p-2">
                            <x-app.documents.preview :document="$document"/>
                        </div>
                        <div class="col-start-4 p-2">
                            <x-buttons.primary wire:click="removeDocument({{ $document->id }})">Remove</x-buttons.primary>
                        </div>
                    </div>
                @endforeach

            </div>

            @if( $job->campus()->exists() && $job->campus->hasMedia( MediaCollections::CAMPUS_APPLICATION_DOCUMENTS->value ) )

                <div class="flex flex-col items-center md:justify-between md:flex-row py-4 border-b border-b-gray-400">
                    <h3><span class="font-bold">School Application Form</span> <a href="#" @click="alert('Download File')">(Download)</a></h3>
{{--                    Table here to list documents to download. --}}
                    <div>
                        <x-input.upload class="w-24 h-24" id="school_application_form" wire:model.live="school_document_upload"/>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-y-2 items-center w-full">

                    @foreach( $school_documents as $index => $document )
                        <div class="py-2 border-b border-b-gray-200 col-span-4 flex gap-2 justify-between items-center">
                            <div class="col-start-1 col-span-2 p-2">
                                <h4>{{ $document->file_name }}</h4>
                            </div>
                            <div class="col-start-3 p-2">
                                <x-app.documents.preview :document="$document"/>
                            </div>
                            <div class="col-start-4 p-2">
                                <x-buttons.primary :shadow="false" wire:click="removeDocument({{ $document->id }})">Remove</x-buttons.primary>
                            </div>
                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </div>

    <div class="col-start-1 col-span-4 pr-5 pl-5 md:pl-0 flex flex-col gap-y-5">
        <div>
            <h4 class="text-app text-xl mt-8 mb-8 text-center">References</h4>
            <p class="text-app">Please note that reference checks are optional.</p>
        </div>

        <div class="flex flex-col gap-y-20">
            @foreach( $references as $index => $reference )
                <x-app.job.application.reference-details id="reference_{{ $index }}" index="{{ $index }}" :reference="$reference" :min_references="$min_references"/>
            @endforeach
        </div>

        @error('references')
            <span class="text-red-500">{{ $message }}</span>
        @enderror

        <div>
            <x-buttons.primary wire:click="addReference">Add Referee</x-buttons.primary>
        </div>

    </div>
</div>

