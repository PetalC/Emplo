<div>

    <div class="grid grid-cols-4 w-full">
        <div class="col-start-1 col-span-12 pr-5 pl-5 md:pl-0 md:pr-0 md:col-start-1 md:col-span-4 flex flex-col gap-10">
            <div class="flex flex-col gap-x-5 align-middle">
                <h4 class="text-app text-xl mb-8 text-center"><span class="font-bold">{{ $job->school->name }}</span> requires the following information be supplied for this position</h4>

                @if( $additional_documents )

                    <h3 class="text-center my-4 text-lg font-light">Please download and complete these additional documents.</h3>

                    <div class="flex flex-col items-center md:justify-between md:flex-row py-4 bg-gray-50">

                        <div class="grid grid-cols-4 gap-y-2 items-center w-full">
                            @foreach( $additional_documents as $document )
                                <div class="py-2 px-4 col-span-4 flex gap-2 justify-between items-center">
                                    <div class="col-start-1 col-span-3">
                                        <h4>{{ $document->file_name }}</h4>
                                    </div>
                                    <div class="col-start-3">
                                        <x-app.documents.preview :document="$document"/>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                @endif

                <div class="flex flex-col items-center md:justify-between md:flex-row py-4 border-y border-y-gray-400">
                    <h3>Please upload your resume and any additional documents</h3>
                    <div>
                        <x-input.upload class="w-24 flex justify-center item-center" id="document_upload" wire:model.live="document_upload" />
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-y-2 items-center w-full">

                    @foreach( $documents as $index => $document )
                        <div class="py-2 border-b border-b-gray-200 col-span-4 flex gap-2 justify-between items-center" wire:key="'document_' . $document->id">
                            <div class="col-start-1 col-span-2 p-2">
                                <h4>{{ $document->file_name }}</h4>
                            </div>
                            <div class="col-start-3 p-2">
                                <x-app.documents.preview :document="$document"/>
                            </div>
                            <div class="col-start-4 p-2">
                                <x-buttons.danger :shadow="false" wire:click="removeDocument({{ $document->id }})">Remove</x-buttons.danger>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-start-1 col-span-4 pr-5 pl-5 md:pl-0 flex flex-col gap-y-5">
            <div>
                <h4 class="text-app text-xl mt-8 mb-8 text-center">References</h4>
                <p class="text-app">Please note that reference checks are optional.</p>
            </div>

            <div class="flex flex-col gap-y-20">
                @foreach( $references as $index => $reference )
                    <livewire:job.application.reference-details wire:key="reference_{{ $reference->id }}" :application="$application" :reference="$reference" />
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

    <div>
        <div class="flex justify-center gap-4 mt-10">
            <x-buttons.secondary :shadow="false" size="xl" wire:click="$parent.previousStep()">Your Details</x-buttons.secondary>
            {{--            <x-buttons.secondary wire:click="$parent.previousStep()">Back</x-buttons.secondary>--}}
            @if( in_array( $this->application?->validated_step, [ 'documents' ] ) )
                <x-buttons.primary :shadow="false" size="xl" wire:click="$parent.call( 'nextStep' )">Review Application</x-buttons.primary>
            @endif
        </div>
    </div>

</div>

