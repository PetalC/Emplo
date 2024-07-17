<?php

namespace Feature\Livewire\Application;

use App\Enums\ApplicationReviewStatuses;
use App\Livewire\Application\PanelReview;
use App\Models\Application;
use App\Models\Campus;
use App\Models\Job;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PanelReviewTest extends TestCase
{
    use RefreshDatabase;
    public function test_application_review()
    {

        School::factory()
            ->has(Campus::factory())
            ->create();
        Job::factory()->count(3)
            ->set('school_id', School::all()->first()->id)
            ->set('campus_id', Campus::all()->first()->id)
            ->set('description', 'unit-test')
            ->set('responsibilities', 'unit-test')
            ->set('required_licences_certs', 'unit-test')
            ->create();
        Application::factory()->count(2)
            ->set('job_id', 1)
            ->set('user_id', 1)
            ->set('campus_id', Campus::all()->first()->id)
            ->create();

        // TODO: add reviewers following panel definition

        $application = Application::find(1);
        $this->assertEmpty($application->reviews);

        // TODO: load valid reviewer
        $reviewer_id = 1;

        $user = User::factory()->create([
            'email' => 'testing@integration.com',
            'first_name' => 'Test',
            'last_name' => 'User'
        ]);

        $this->actingAs($user);

        Livewire::test(PanelReview::class, ['application' => $application])
            ->call('approve');

        // Reload from DB
        $newApplication = Application::find(1);

        $this->assertTrue(count($newApplication->reviews) == 1, 'approving applicant failed to add review');
        $this->assertEquals('testing@integration.com', $newApplication->reviews->first()->member->email);
        $this->assertEquals(ApplicationReviewStatuses::APPROVED->value, $newApplication->reviews->first()->status->value, 'Failed to set review to approved');

        // Reload from DB
        $newNewApplication = Application::find(1);

        Livewire::test(PanelReview::class, ['application' => $newNewApplication])
            ->call('decline');

        $this->assertTrue(count($newNewApplication->reviews) == 1, 'Should only be one review still, but got '.count($newNewApplication->reviews));
        $this->assertEquals(ApplicationReviewStatuses::DECLINED->value, $newNewApplication->reviews->first()->status->value, 'Failed to set review to declined');


    }

}
