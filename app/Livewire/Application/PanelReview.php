<?php

namespace App\Livewire\Application;

use App\Enums\ApplicationReviewStatuses;
use App\Livewire\Forms\MultiSelect;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class PanelReview extends MultiSelect
{
    #[Locked]
    public Application $application;
    #[Locked]
    public Collection $reviewers;
    #[Locked]
    public Collection $reviews;

    public function mount() {
        $this->reviewers = $this->application->job->panel_members;
//        $this->reviews = $this->application->reviews;
    }

    public function getInitials(User $reviewer): string {
        return strtoupper($reviewer->first_name[0] . $reviewer->last_name[0]);
    }

    public function getReviewClasses(User $reviewer) {
        $review = $this->application->reviews()->where( 'member_id', '=', $reviewer->id )->first();

        if (!$review)
            return 'text-black';

        switch ($review->status) {
            case ApplicationReviewStatuses::APPROVED:
                return 'bg-success text-white';
            case ApplicationReviewStatuses::DECLINED:
                return 'bg-danger text-white';
            case ApplicationReviewStatuses::PENDING;
            default:
                return 'text-black';
        }
    }

    public function flagApplicant(){

        $exists = $this->application->job->school->flagged_users()
            ->where( 'user_id', '=', $this->application->user_id )
            ->exists();

        if( ! $exists ){
            $this->application->job->school->flagged_users()->attach( $this->application->user_id, [ 'flagged_by' => auth()->user()->id, 'flagged_at' => now() ] );
        }

        // Dirty hack to force a refresh of the page
        $this->redirect( route('school.applicants.view', $this->application->job ) );

    }

    public function approve() {
        $this->updateReview( auth()->user(), ApplicationReviewStatuses::APPROVED );
    }

    public function decline() {
        $this->updateReview( auth()->user(), ApplicationReviewStatuses::DECLINED );
    }

    public function updateReview(User $reviewer, $status) {

        $review = $this->application->reviews()->where( 'member_id', '=', $reviewer->id )->first();

//        dd( $reviewer, $review, $status );

        if (!$review) {
            $this->application->reviews()->create([
                'member_id' => $reviewer->id,
                'status' => $status,
            ]);
        } else {
            $review->update([
                'status' => $status,
            ]);
        }

        // Dirty hack to force a refresh of the page
        $this->redirect( route('school.applicants.view', $this->application->job ) );

    }

    public function render() {
        return view('livewire.application.panel-review');
    }

}
