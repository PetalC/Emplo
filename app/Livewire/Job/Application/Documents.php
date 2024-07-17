<?php

namespace App\Livewire\Job\Application;

use App\Enums\ApplicationReferenceCheckStatuses;
use App\Enums\MediaCollections;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Symfony\Component\Uid\Ulid;

class Documents extends Component {
    use WithFileUploads;

    public Job $job;

    #[Modelable]
    public Application $application;

    public $documents;

    public Collection $additional_documents;

    public array $references = [];

    public TemporaryUploadedFile|string|null $document_upload = null;

    public function rules(){

        return [
            'document_upload' => 'sometimes|nullable|file|max:10240', // 10MB
            'references.*.full_name' => 'required|string',
            'references.*.email' => 'required|email',
            'references.*.phone_number' => 'required|string',
            'references.*.position' => 'required|string',
        ];

    }

    public function mount(){

        /**
         * Ge the documents added to the job for applicants to complete.
         */
        $this->documents = $this->application->getMedia(MediaCollections::APPLICATION_DOCUMENTS->value);

        $this->additional_documents = $this->job->getMedia(MediaCollections::JOBCENTRE_JOB_DOCUMENTS->value);

        $this->loadReferences();

    }

    public function updatedDocumentUpload( $value ){
        $this->validate([
            'document_upload' => 'required|file|max:5120', // 5MB
        ]);

        $this->application->addMedia( $this->document_upload )
            ->usingFileName( $this->document_upload->getClientOriginalName() )
            ->toMediaCollection( MediaCollections::APPLICATION_DOCUMENTS->value );

        $this->document_upload = null;

        $this->documents = $this->application->getMedia(MediaCollections::APPLICATION_DOCUMENTS->value);

        if ($this->documents->count() > 0) {
            $this->application->validated_step = 'documents';
            $this->application->save();
        }

    }

    public function updated( $property, $value ){
        $this->validateOnly( $property );
    }

    public function addReference(){

        $this->application->reference_checks()->create( [
            'ulid' => Ulid::generate( now() ),
            'referee_id' => 0,
            'candidate_id' => $this->application->user->id,
            'status' => ApplicationReferenceCheckStatuses::INTRO,
            'comment' => '',
        ] );

        $this->loadReferences();

    }

    public function loadReferences(){
        $this->references = $this->application->reference_checks->all();
    }

    public function removeReference( $reference_id ){

        $this->application->reference_checks()->where( 'id', $reference_id )->delete();

        $this->loadReferences();
    }

    public function removeDocument( $document_id ){

//        $this->application->deleteMedia( $document_id );

        $this->application->media()->where( 'id', '=', $document_id )->first()->delete();

//        sleep( 5 ); // Wait for the media to be deleted.

        $this->documents = $this->application->getMedia( MediaCollections::APPLICATION_DOCUMENTS->value );
        if ($this->documents->count() <= 0) {
            $this->application->validated_step = 'criteria';
            $this->application->save();
            
            throw \Illuminate\Validation\ValidationException::withMessages([
                'documents' => 'A CV must be uploaded.'
            ]);
        }
//
//        dd( $this->documents->count() );

//        $this->documents

//        $this->render();

    }

    public function render()
    {

//        $this->documents = $this->application->getMedia(MediaCollections::APPLICATION_DOCUMENTS->value);

        return view('livewire.job.application.documents');
    }
}
