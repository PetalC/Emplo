<?php

namespace App\Livewire\Application;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use App\Enums\MediaCollections;

class Documents extends Component
{

    use WithFileUploads;

    public Application $application;

    public string|TemporaryUploadedFile $uploadFile = '';
//
//    public function mount( Application $application )
//    {
//        $this->application = $application;
//        $this->uploadFile = '';
//    }

    public function rules()
    {
        return [
            'uploadFile' => 'sometimes|nullable|file|max:2048',
        ];
    }

    public function removeDocument( $document_id ): void
    {
        try {
            $this->application->media()->where( 'id', '=', $document_id )->first()->delete();
            session()->flash('message', 'Document deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting document.');
        }
    }

    public function updated( $field, $value )
    {
        $this->validateOnly($field);

        switch ($field) {
            case 'uploadFile':
                $collectionName = MediaCollections::APPLICATION_DOCUMENTS->value;

                $this->application->addMedia($this->uploadFile)
                    ->withCustomProperties(
                        [
                            'internalUpload' => true,
                            'uploadedBy' => Auth::id(),
                        ])
                    ->toMediaCollection($collectionName);

                $this->uploadFile = '';
                break;
        }
    }

    public function render()
    {

//        @dump($this->application->id);
        $mediaCollection = $this->application->getMedia(MediaCollections::APPLICATION_DOCUMENTS->value);

        return view('livewire.application.documents', [
            'mediaCollection' => $mediaCollection
        ]);
    }
}
