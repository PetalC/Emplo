<?php

namespace App\Livewire\Job\Application;

use App\Enums\ApplicationStatuses;
use App\Enums\MediaCollections;
use App\Enums\SchoolFollowerType;
use App\Models\Application;
use App\Models\Job;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Review extends Component {

    #[Modelable]
    public Application $application;

    public Job $job;

    public function submitApplication(){
        $this->application->status = ApplicationStatuses::STATUS_SUBMITTED;
        $this->application->save();

        $this->dispatch( 'refresh_application' );

        // Add the user as a school follower if they are not already following the school
        if( $this->job->campus->followers()->where( 'user_id', auth()->id() )->doesntExist() ){
            $this->job->campus->followers()->attach( auth()->id(), [
                'type' => SchoolFollowerType::APPLIED->value
            ] );
        }

    }

    public function render() {

        $rows = [];

        $media = $this->application->getMedia( MediaCollections::APPLICATION_DOCUMENTS->value );

        if( $media->isNotEmpty() ){
            foreach( $media as $_media ){
                $rows[] = [
                    'name' => $_media->name,
                    'is_ticked' => true,
                ];
            }
        } else {
            $rows[] = [
                'name' => 'No documents provided',
                'is_ticked' => false,
            ];
        }

        if( $this->application->reference_checks()->exists() ){
            $rows[] = [
                'name' => 'References Provided',
                'is_ticked' => true,
            ];
        } else {
            $rows[] = [
                'name' => 'No references provided',
                'is_ticked' => false,
            ];
        }

        return view('livewire.job.application.review')->with( [
            'rows' => $rows,
        ] );

    }

}
