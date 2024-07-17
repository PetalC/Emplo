<div x-data="{ openCreateFolderModal: false }"  class="max-w-8xl mx-auto sm:px-20 px-0 my-10">
    {{-- Create folder modal --}}
    <x-modal
        x-show="openCreateFolderModal"
        x-on:click.outside="openCreateFolderModal = false"
        onClose="openCreateFolderModal = false"
    >
        <div class="flex flex-col gap-10 items-center">
            <div>
                <p class="text-3xl text-gray-500">Folder Name</p>
                <div class="mt-10 w-full">
                    <x-input.outline class="w-full" wire:model.live.debounce.200ms="newFolderName" id="name" name="name" class="!text-2xl !font-light pb-2" required />
                </div>
            </div>
            <x-button.primary wire:click="createFolder(); openCreateFolderModal = false"
            >Done</x-button.primary>
        </div>
    </x-modal>

    <div class="flex sm:flex-row flex-col rounded-lg border min-h-96 p-5 gap-8 text-2xl text-app">
        <div class="sm:w-1/2 gap-2 flex flex-col w-[100%]">
            <p class="px-12 py-4 sm:text-2xl text-base font-bold rounded-lg {{ $this->parentFolder === 'employo' ? 'bg-primary text-white' : '' }}" wire:click="selectFolder('employo')">Employo Templates</p>
            <p class="px-12 py-4 sm:text-2xl text-base font-bold rounded-lg {{ $this->parentFolder === 'custom' ? 'bg-primary text-white' : '' }}" wire:click="selectFolder('custom')">My Custom Templates</p>

        </div>
        <div class="sm:w-1/2 w-[100%]">
            @if($this->selectedFolder != '')
                <div class="w-full gap-2 flex flex-col">
                    @if($selectedFolder === 'custom')
                        <x-button.outline x-on:click="openCreateFolderModal = true"  fullWidth class="justify-start text-sm sm:text-2xl" variant="left"><x-icon name="heroicon-o-plus" class="w-8 h-8 mr-5" /> <span class="text-app text-2xl">Create New Folder</span></x-button.outline>
                        @foreach($userFolders as $folder => $name)
                            <p class="px-12 py-4 text-sm er == $key ? 'bg-primary text-white' : '' }}" wire:click="selectFolder('{{ $folder }}')">{{ $name }}</p>
                        @endforeach

                    @elseif($selectedFolder === 'employo')
                        <pre>School ID {{ $school->id }}</pre>
                        @foreach($schoolResources as $key => $resource)
                            <p class="px-12 py-4 text-sm er == $key ? 'bg-primary text-white' : '' }}" wire:click="selectFolder('{{ $key }}')">{{ $resource['title'] }}</p>
                        @endforeach
                    @else
                        <x-button.outline fullWidth class="justify-start text-sm sm:text-2xl" variant="left"  wire:click="selectFolder('{{ $parentFolder }}')" ><x-icon name="heroicon-o-arrow-left" class="w-8 h-8 mr-5" /> <span class="text-app text-sm sm:text-2xl" >{{ $folderTitle }}</span></x-button.outline>
                        <div>
                            <div class="w-full mt-16 flex gap-10 items-center">
                                <x-input.upload class="max-w-56 w-56 h-56" id="upload_file" accept="*" wire:model.live="uploadFile" />
                                <p class="text-gray-500 flex-grow">
                                    Upload new template
                                </p>
                            </div>
                        </div>
                        @if($parentFolder === 'employo')
                            <pre>School ID {{ $school->id }}</pre>
                            <pre>Folder key {{ $this->selectedFolder }}</pre>
                            @foreach($schoolResources[$this->selectedFolder]['files'] as $key => $resource)
                                    <div class="px-12 py-4 flex justify-between">
                                        <p>{{ $resource->name }}</p>
                                        <a class="underline" href="{{ $resource->getUrl() }}" download>Download</a>
                                    </div>
                            @endforeach
                        @elseif($parentFolder === 'custom')
                            @foreach($userResources[$this->selectedFolder]['files'] as $key => $resource)
                                <div class="px-12 py-4 flex justify-between">
                                    <p>{{ $resource->name }}</p>
                                    <a class="underline" href="{{ $resource->getUrl() }}" download>Download</a>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            @endif
    </div>
    </div>
</div>
