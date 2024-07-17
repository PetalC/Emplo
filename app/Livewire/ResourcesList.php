<?php

namespace App\Livewire;

use App\Models\School;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Enums\MediaCollections;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ResourcesList extends Component
{

    use WithFileUploads;

    public $search = '';

    public $selectedFolder = 'employo';

    public $parentFolder = 'employo';

    public $folderTitle = '';

    public string $newFolderName = '';

    public string $folderPath = '';

    public School $school;

    public array $debug;

    public array $schoolResources;

    public array $userResources;

    public array $userFolders = [];

    #[Locked]
    public array $resourceFolders = [
        'advertising-resources' => 'Advertising resources',
        'contract-templates' => 'Contract templates',
        'email-templates' => 'Email templates',
        'reference-templates' => 'Reference templates',
        'selection-resources' => 'Selection resources',
    ];

    public string|TemporaryUploadedFile $uploadFile = '';

    public function rules(){
        return [
            'uploadFile' => 'required|file|max:2048',
        ];
    }

    public function mount(School $school)
    {
        $this->school = $school;
        $this->debug = [];
    }

    public function updated($field)
    {
        $this->validateOnly( $field );

        switch( $field ) {
            case 'uploadFile':

                $customProperties = ['resourceFolder' => $this->selectedFolder];
                if($this->parentFolder === 'employo'){
                    $collectionName = MediaCollections::SCHOOL_RESOURCES->value;
                } else {
                    $collectionName = MediaCollections::USER_RESOURCES->value;
                    $customProperties['userID'] = Auth::id();
                }

               $this->school->addMedia( $this->uploadFile )
                    ->withCustomProperties($customProperties)
                    ->toMediaCollection( $collectionName );
                break;
            default:
                break;
        }
    }

    public function createFolder()
    {
        // Set up the keys in the user Resources array so the FE displays the folder & title when modal closes
        $slug = Str::slug($this->newFolderName);

        $this->userResources[$slug]['title'] = ucwords($this->newFolderName);
        $this->userResources[$slug]['files'] = [];

        $this->selectFolder($slug);
    }


    public function selectFolder($newValue)
    {
        if(array_key_exists($newValue, $this->resourceFolders) || $newValue === 'employo'){
            $this->parentFolder = 'employo';

            if($newValue !== 'employo'){
                $this->folderTitle = $this->schoolResources[$newValue]['title'];
            }
        } else {
            $this->parentFolder = 'custom';

            if($newValue !== 'custom'){
                    $this->folderTitle = $this->userResources[$newValue]['title'];
            }
        }

        $this->selectedFolder = $newValue;
    }

    public function render()
    {
        // Get the ID of the logged-in user
        $user_id = Auth::id();

        $this->debug['school'] = $this->school->id;

        foreach($this->resourceFolders as $key => $name){

            $folder = Str::slug($name);

            $this->schoolResources[$folder]['files'] = $this->school->getMedia(MediaCollections::SCHOOL_RESOURCES->value , ['resourceFolder' => $folder]);
            $this->schoolResources[$folder]['title'] = $name;

        }

        // Fetch resources belonging to the logged-in user
       $userCustomResources = $this->school->getMedia(MediaCollections::USER_RESOURCES->value , ['userID' => $user_id]);

        foreach ($userCustomResources as $resource) {
            $path = $resource->getCustomProperty('resourceFolder');

            $folder = Str::slug($path);

            if(!in_array($folder, $this->userFolders)){
                $this->userFolders[$folder] = $path;
            }

            $this->userResources[$folder]['files'][] = $resource;
            $this->userResources[$folder]['title'] = $path;

        }

        return view('livewire.resources-list');
    }
}
