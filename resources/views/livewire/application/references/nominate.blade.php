<div class="max-w-7xl mx-auto pt-6">
    <div class="p-20 mb-20 border rounded-2xl">
    <div class="gap-10 w-full pt-20">
        <div class="pr-20 pl-20 md:pl-0 md:pr-0 md:pb-5 md:col-start-1 md:col-span-4 flex flex-col gap-10">
            <div class="flex flex-col md:grid md:grid-cols-2 md:flex-row gap-x-5 gap-y-16">
                <div class="flex flex-col col-span-2">
                    <span class="font-bold col-start-2">References</span>
                    <span class="col-start-2">Please note that reference checks are mandatory in the recruitment of all staff.</span>
                </div>

                <div class="flex flex-col gap-y-20 col-span-2">
                    @foreach( $references as $index => $reference )
                        <x-app.job.application.reference-details id="reference_{{ $index }}" index="{{ $index }}"
                                                                 :reference="$reference"
                                                                 :min_references="$min_references"/>
                    @endforeach
                    <div class="flex justify-center content-center">
                        <x-buttons.primary wire:click="addReference">Add Referee</x-buttons.primary>
                    </div>
                </div>

                @error('references')
                <span class="text-red-500">{{ $message }}</span>
                @enderror

                <div class="py-10 md:col-span-2 flex flex-col">
                    <x-input.checkbox id="save_details" name="save_details" :value="true" label="Save my details for future job applications" wire:model.blur="save_details" />
                    @error('save_details')
                    <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-buttons.primary wire:click="saveReferences">Submit</x-buttons.primary>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
